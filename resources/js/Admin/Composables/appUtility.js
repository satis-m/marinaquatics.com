import {ref} from "@vue/runtime-core";

export function useAppUtility() {

    const themeOption = function (key) {
        return App.themeOption[key];
    }
    const siteUrl = function (link = "", opt = "") {
        if (opt == "api") return App.siteUrl + "/api/v1/" + link;
        return App.siteUrl + link;
    }
    const verifyRole = function (role) {
        if (window.App.user.role.role_name == role) return true;
        return false;
    }
    const smoothScrollIntoView = function (identifier) {
        setTimeout(() => {
            document.querySelector(identifier).scrollIntoView({
                behavior: "smooth"
            });
        }, 500);
    }
    const ifUrlExist = async (url) => {
        if (url == '' || url == null)
            return false

        try {
            const response = await fetch(url, {
                method: 'HEAD',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'Accept': '*/*',
                },
            });

            if (response.ok) {
                return true;
            }
        } catch (error) {
            console.error('Error while checking URL:', error);
        }

        return false;
    }
    const isAuthorize = function () {
        const userRole = window.App.user.role.role_name;
        const allowedRole = ["su_admin"];
        return allowedRole.includes(userRole.toLowerCase());
    }
    const mobileAndTabletCheck = function () {
        let check = false;
        (function (a) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    }

    const mediaCheck = function (opt) {
        switch (opt) {
            case 'sm':
                return window.matchMedia("(max-width: 575.98px)").matches; // X-Small devices (portrait phones, less than 576px)
                break;
            case 'md':
                return window.matchMedia("(max-width: 767.98px)").matches; // Small devices (landscape phones, less than 768px)
                break;
            case 'lg':
                return window.matchMedia("(max-width: 991.98px)").matches; // Medium devices (tablets, less than 992px)
                break;
            case 'xl':
                return window.matchMedia("(max-width: 1199.98px)").matches; // Large devices (desktops, less than 1200px)
                break;
            case '2xl':
                return window.matchMedia("(max-width: 1399.98px)").matches; // X-Large devices (large desktops, less than 1400px)
                break;
            default:
                return false;
                break;
        }
    }
    const getMenuKey = function (object, key) {

    }

    //dynamically load java script library source
    const loadScript = function (url, callback) {
        const scripts = document.querySelectorAll("script[type='text/javascript']");
        let isloaded = false;
        scripts.forEach((item) => {
            if (item.src == url) isloaded = true;
        });
        if (isloaded) return callback();
        var script = document.createElement("script");
        script.type = "text/javascript";

        if (script.readyState) {
            script.onreadystatechange = function () {
                if (
                    script.readyState == "loaded" ||
                    script.readyState == "complete"
                ) {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {
            script.onload = function () {
                callback();
            };
        }
        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    };
    const isScreenMd = ref(mediaCheck("md"))
    const isScreenLg = ref(mediaCheck("lg"))
    window.addEventListener("resize", () => {
        isScreenMd.value = mediaCheck("md");
        isScreenLg.value = mediaCheck("lg");
    });
    //dark mode function
    const isDarkScheme = () => localStorage.theme === "dark";
    const isDarkMode = ref(isDarkScheme())
    document.documentElement.addEventListener(
        "change-color-scheme",
        (e) => {
            isDarkMode.value = isDarkScheme();
        },
        false
    );

    const setDarkScheme = () => {
        // Whenever the user explicitly chooses dark mode
        localStorage.theme = "dark";
        document.documentElement.classList.add("dark");
    };
    const setLightScheme = () => {
        // Whenever the user explicitly chooses light mode
        localStorage.theme = "light";
        document.documentElement.classList.remove("dark");
    };
    const setDefaultScheme = () => {
        // Whenever the user explicitly chooses to respect the OS preference
        localStorage.removeItem("theme");
    };

    const isSlowConnection = () => {
        if ("connection" in navigator) {
            const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
            //console.log(connection.effectiveType);
            // Check if effectiveType is available (Chrome and other supporting browsers)
            if ("effectiveType" in connection) {
                // Possible values for connection.effectiveType are 'slow-2g', '2g', '3g', and '4g'.
                // You can adjust the threshold based on your preference.
                return connection.effectiveType === "slow-2g" || connection.effectiveType === "2g" || connection.effectiveType === "slow-3g";
            }

            // Check if saveData is available (Opera and other supporting browsers)
            if ("saveData" in connection) {
                return connection.saveData;
            }
        }

        // If connection information is not available or not supported, assume it's not a slow connection
        return false;
    };
    const lazyLoadVideo = (lazyVideos)=>
    {
        if(!isSlowConnection())
        {
            var lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(video) {
                    if (video.isIntersecting) {
                        for (var source in video.target.children) {
                            var videoSource = video.target.children[source];
                            if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
                                videoSource.src = videoSource.dataset.src;
                            }
                        }

                        video.target.load();
                        video.target.classList.remove("lazy");
                        lazyVideoObserver.unobserve(video.target);
                    }
                });
            });

            lazyVideos.forEach(function(lazyVideo) {
                lazyVideoObserver.observe(lazyVideo);
            });
        }
    }

    return {
        ifUrlExist,
        isAuthorize,
        mobileAndTabletCheck,
        siteUrl,
        smoothScrollIntoView,
        themeOption,
        verifyRole,
        mediaCheck,
        isScreenMd,
        isScreenLg,
        loadScript,
        isDarkScheme,
        isDarkMode,
        setDarkScheme,
        setLightScheme,
        setDefaultScheme,
        isSlowConnection,
        lazyLoadVideo
    }
}
