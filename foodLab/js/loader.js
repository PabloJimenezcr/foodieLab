document.addEventListener("DOMContentLoaded", function () {
    TweenMax.to(".overlay img", 2, {
        opacity: 0,
        y: -60,
        ease: Expo.easeInOut
    });

    TweenMax.to(".overlay h1", 2, {
        opacity: 0,
        y: -60,
        ease: Expo.easeInOut,
        delay: 0.5
    });

    TweenMax.to(".overlay p", 2, {
        delay: 1,
        opacity: 0,
        y: -60,
        ease: Expo.easeInOut,
    });

    TweenMax.to(".overlay", 2, {
        delay: 1,
        top: "-100%",
        ease: Expo.easeInOut,
        onComplete: function () {
            document.body.classList.remove("loading");
            document.body.style.overflow = "visible";
        }
    });
});
