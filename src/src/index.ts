import "./scss/style.scss";
import 'bootstrap';
import debounce from 'lodash.debounce';
// @ts-ignore
import Glide from '@glidejs/glide'

import "@glidejs/glide/src/assets/sass/glide.core";
import "@glidejs/glide/src/assets/sass/glide.theme";

const initNavigation = () => {
    const nav = document.getElementById("navi-bar");
    if (nav) {
        let navHeight = nav.offsetHeight;
        let lastScrollTop = 0;

        const burger = nav.querySelector(".burger");
        const submenu = nav.querySelector("div.level_1");
        if (burger && submenu) {
            burger.addEventListener("click", () => {
                submenu.classList.toggle("open");
            });
        }

        const handleScroll = () => {
            let st = window.pageYOffset || document.documentElement.scrollTop;
            if (st > lastScrollTop) {
                // down scroll
                if (st > navHeight) {
                    nav.classList.add("disable");
                    nav.classList.remove("static");
                    nav.classList.remove("disable");
                }
                nav.classList.remove("fixed");
            } else {
                // up scroll
                if (st < navHeight) {
                    nav.classList.add("static");
                    nav.classList.remove("fixed");
                } else {
                    nav.classList.add("fixed");
                }
            }
            lastScrollTop = st <= 0 ? 0 : st;
        };

        const debouncedScrollHandler = debounce(handleScroll, 50, {
            'leading': true,
        });

        window.addEventListener('scroll', (e) => {
            debouncedScrollHandler();
        });
    }
};


const onReady = function () {
    initNavigation();

    document.querySelectorAll(".glide")
        .forEach((ref: Element) => {
            let config = {};
            const strAdditionalConfig = ref.getAttribute("data-config");
            if (strAdditionalConfig) {
                const additionalConfig = JSON.parse(strAdditionalConfig);
                config = {
                    ...config,
                    ...additionalConfig
                };
            }

            const numSlides: number = ref.querySelectorAll(".glide__slide").length;
            if( numSlides > 0 ) {
                const bullets = ref.querySelector(".glide__bullets");
                if (bullets) {
                    for (let i = 0; i < numSlides; i++) {
                        const button = document.createElement("button");
                        button.classList.add("glide__bullet");
                        button.setAttribute("data-glide-dir", "=" + i);
                        bullets.append(button);
                    }
                }
            }

            new Glide("#" + ref.id, config).mount();
        });


};

if (
    document.readyState === "complete" ||
    // @ts-ignore
    (document.readyState !== "loading" && !document.documentElement.doScroll)
) {
    onReady();
} else {
    document.addEventListener("DOMContentLoaded", onReady);
}
