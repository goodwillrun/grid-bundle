<?php

namespace GOODWILLRUN\GridBundle\Classes;

use Contao\StringUtil;
use Contao\System;

/**
 * Class ImageHelper
 */
class ImageHelper
{
    const USE_EXEC = true;
    private static $use_exec = self::USE_EXEC;

    public static function setUseExec(bool $use_exec)
    {
        self::$use_exec = $use_exec;
    }

    public static function getFileSize(string $filePath): int
    {
        $objFile = self::getFileByPath($filePath);
        if ($objFile)
            return $objFile->size;
        return -1;
    }

    public static function getImageWidth(string $imageFilePath): int
    {
        $objFile = self::getFileByPath($imageFilePath);
        if ($objFile)
            return $objFile->width;
        return -1;
    }

    public static function getImageHeight(string $imageFilePath): int
    {
        $objFile = self::getFileByPath($imageFilePath);
        if ($objFile)
            return $objFile->height;
        return -1;
    }

    private static function executeImagickCommand(string $input, int $width, int $height, string $output)
    {
        $cmd = "convert '$input' -quality 96 -filter Lanczos -resize " . $width . "x" . $height . " -unsharp 0x1 '$output' ";
        echo "<!-- Generating image using '" . $cmd . "' -->";
        $debug = " with command: " . $cmd;
        $debug .= " and output: " . exec($cmd);
        return $debug;
    }


    public static function generateImageFile(string $sourceFilePath, int $width, int $height)
    {
        $sourceFilePathParts = pathinfo($sourceFilePath);
        $sourceFileExtension = strtolower($sourceFilePathParts["extension"]);
        $tempFolder = StringUtil::stripRootDir(System::getContainer()->getParameter('contao.image.target_dir')) . "/";
        if (!file_exists($tempFolder . $sourceFilePathParts['dirname'])) {
            mkdir($tempFolder . $sourceFilePathParts['dirname'], 0777, true);
        }
        $targetFilePath = $tempFolder . $sourceFilePathParts['dirname'] . "/" . $sourceFilePathParts['filename'] . "-" . $width . "-" . $height . ".png";

        if (file_exists($targetFilePath)) {
            return new \Contao\File($targetFilePath);
        }
        $supportedImagePaths = array('tif', 'tiff', 'svg', 'eps', 'ai', 'pdf', 'png', 'jpg', 'jpeg', 'bmp');
        if (in_array($sourceFileExtension, $supportedImagePaths)) {
            try {
                if ($sourceFileExtension == 'pdf') {
                    $sourceFilePath .= "[0]";
                }
                $debug = "";
                if (self::$use_exec) {
                    $debug = "Used Imagick via EXEC";
                    $debug .= self::executeImagickCommand($sourceFilePath, $width, $height, $targetFilePath);
                } else {
                    $debug = "Used Imagick PHP library";
                    $image = new Imagick($sourceFilePath);
                    $image->setResolution($width, $height);
                    $image->setImageFormat("png");
                    $image->writeImage($targetFilePath);
                }
                // Check for existance
                if (!file_exists($targetFilePath)) {
                    echo "<!-- ERROR: file has not been generated $targetFilePath -->";
                    throw new \Exception("Target file " . $targetFilePath . " has not been generated. " . $debug);
                }
                $objFile = new \Contao\File($targetFilePath);
                $objFile->save();
                //$objFile = FilesModel::findByPath($targetFilePath);
                /*if (!$objFile) {
                    echo "<!-- ERROR: could not get file $targetFilePath -->";
                    // Add image to Contao library
                    $objFile = \Dbafs::addResource($targetFilePath);
                }*/
                return $objFile;
            } catch (\Exception $e) {
                throw new \Exception('Could not generate image from source file ' . $sourceFilePath . '', 1, $e);
            }
        } else {
            throw new \Exception("Invalid source file format " . $sourceFilePathParts["extension"] . " of file " . $sourceFilePath);
        }
    }

    protected static function getImagesSizeObject($imageSizeId)
    {
        return \Contao\ImageSizeModel::findById($imageSizeId);
    }


    public static function getFilePathByUUID(string $strUuid): ?string
    {
        $filesModel = self::getFilesModelByUUID($strUuid);
        if ($filesModel)
            return urldecode($filesModel->path);
        return null;
    }

    public static function getFilesModelByUUID(string $strUuid): ?\Contao\FilesModel
    {
        $filesModel = \Contao\FilesModel::findById($strUuid);
        if ($filesModel) {
            return $filesModel;
        }
        return null;
    }

    public static function getFileByUUID(string $strUuid): ?\Contao\File
    {
        $filePath = self::getFilePathByUUID($strUuid);
        if ($filePath) {
            if (is_file($filePath)) {
                return new \Contao\File($filePath);
            } else {
                //throw new \Exception("File $filePath is a directory");
            }
        }
        return null;
    }

    public static function getFileByPath(string $filePath): ?\Contao\File
    {
        if ($filePath) {
            return new \Contao\File(urldecode($filePath));
        }
        throw new \Exception("Didn't find anything at $filePath");
    }

    public static function getOptimizedImageWithSize(string $strUuid, string $strSize): ?\Contao\Image
    {
        $objFile = self::getFileByUUID($strUuid);

        if ($objFile) {
            $arrSize = StringUtil::deserialize($strSize);

            if ($arrSize && count($arrSize) == 3) {
                // Resize image
                $intWidth = $arrSize[0];
                $intHeight = $arrSize[1];
                $strMode = $arrSize[2];

                if ($intWidth == 0 && $intHeight == 0) {
                    $imageSizeId = $strMode;
                    $imageSize = self::getImagesSizeObject($imageSizeId);
                    $intWidth = $imageSize->width;
                    $intHeight = $imageSize->height;
                    $strMode = $imageSize->resizeMode;
                }
                $objImg = self::generateImageFile($objFile->path, $intWidth, $intHeight);

                if ($objImg) {
                    //$objResizedFile = self::getFileByPath($objImg);
                    $objResizedImage = new \Contao\Image($objImg);
                    return $objResizedImage;
                } else {
                    return new \Contao\Image($objFile);
                }
            } else {
                throw new \Exception('Invalid resize parameter given for file with UUID ' . $strUuid);
            }
        }
        return null;
    }

    public static function getImageWithSize(string $strUuid, string $strSize): ?\Contao\Image
    {
        $objFile = self::getFileByUUID($strUuid);
        if ($objFile) {
            $arrSize = deserialize($strSize);

            if ($arrSize && count($arrSize) == 3) {
                // Resize image
                $intWidth = $arrSize[0];
                $intHeight = $arrSize[1];
                $strMode = $arrSize[2];

                if ($intWidth == 0 && $intHeight == 0) {
                    $imageSizeId = $strMode;
                    $imageSize = self::getImagesSizeObject($imageSizeId);
                    $intWidth = $imageSize->width;
                    $intHeight = $imageSize->height;
                    $strMode = $imageSize->resizeMode;
                }
                $objImg = new \Contao\Image($objFile);

                $objImg->setTargetWidth($intWidth);
                $objImg->setTargetHeight($intHeight);
                $objImg->setResizeMode($strMode);
                /*
                try {
                    $objImg->computeResize();
                } catch (Exception $e) {
                    throw new InvalidArgumentException('Invalid target dimension of ' . $intWidth . 'x' . $intHeight . ' for image ' . $file->path);
                }*/
                $objImg->executeResize();
                $objResizedFile = self::getFileByPath($objImg->getResizedPath());
                $objResizedImage = new \Contao\Image($objResizedFile);
                return $objResizedImage;
            } else {
                throw new \Exception('Invalid resize parameter given for file with UUID ' . $strUuid);
            }
        }
        return null;
    }

    public static function getImage(string $strUuid): ?\Contao\Image
    {
        $filePath = self::getFilePathByUUID($strUuid);
        if ($filePath) {
            $image = \Contao\Image::create($filePath);
            if ($image) {
                // prepare image
                if ($image->getTargetWidth() > 0 && $image->getTargetHeight() > 0) {
                    $image->computeResize();
                    $image->executeResize();
                }
                return $image;
            } else {
                throw new \Exception('Could not create image of path "' . $filePath);
            }
        }
        return null;
    }

    public static function getImagePathWithImportantPart(string $imageId): ?string
    {
        $objFile = self::getFileByUUID($imageId);
        if ($objFile) {
            $imageObj = new \Contao\Image($objFile);
            if ($imageObj) {
                if ($imageObj->getImportantPart() != null) {
                    $importantPart = $imageObj->getImportantPart();
                    $width = $importantPart['width'];
                    $height = $importantPart['height'];
                    $imageObj->setImportantPart($importantPart)->setTargetWidth($width)->setTargetHeight($height);
                    //$imageObj->computeResize();
                    return $imageObj->executeResize()->getResizedPath();
                }
            }
            throw new \Exception("Given file at $objFile->path is no image");
        }
        return null;
    }

    public static function getImageWithImportantPart(string $strUuid): ?\Contao\Image
    {
        $fileObj = self::getFileByUUID($strUuid);
        if ($fileObj) {
            $imageObj = \Contao\Image($fileObj);
            if ($imageObj->getImportantPart() != null) {
                $importantPart = $imageObj->getImportantPart();
                $width = $importantPart['width'];
                $height = $importantPart['height'];
                $imageObj->setImportantPart($importantPart)->setTargetWidth($width)->setTargetHeight($height);
                $imageObj->computeResize();
                $objResizedFile = self::getFileByPath($imageObj->getResizedPath());
                $objResizedImage = new \Contao\Image($objResizedFile);
                return $objResizedImage;
            }
            // Just return the original image
            return $imageObj;
        }
        return null;
    }
}
