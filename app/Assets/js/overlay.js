
const targetNode = document.querySelector('.flashes_wrapper');
const config = { attributes: true, childList: true, subtree: true, };

const shutter = document.querySelector('.flashes_close');
const list = document.querySelector('.flashes_list');

const load_overlay = document.querySelector('.overlay.load_overlay');
const load_overlay_trigger = document.querySelector('.submit_form.button');
const logout_button = document.querySelector('.logout_button');

//prepared for ajaxification
const callback = function (mutationsList, observer) {
    for (const mutation of mutationsList) {
        if (mutation.type === 'childList') {
            const elem = document.querySelector(".flash_message");
            if (typeof (elem) != 'undefined' && elem != null) {
                targetNode.classList.add('visible');
            } else {
                targetNode.classList.remove('visible');
            }
        }
    }
};

const observer = new MutationObserver(callback);
observer.observe(targetNode, config);

window.addEventListener('load', function () {
    const elem = document.querySelector(".flash_message");
    if (typeof (elem) != 'undefined' && elem != null) {
        targetNode.classList.add('visible');
    } else {
        targetNode.classList.remove('visible');
    }
    if (typeof (shutter) != 'undefined' && shutter != null) {
        shutter.addEventListener('click', function (e) {
            e.stopPropagation();
            list.innerHTML = '';
            targetNode.classList.remove('visible');
        })
    }
    if (typeof (load_overlay_trigger) != 'undefined' && load_overlay_trigger != null) {
        load_overlay_trigger.addEventListener('click', function (e) {
            load_overlay.style.display = 'block';
        })
    }
    if (typeof (logout_button) != 'undefined' && logout_button != null) {
        logout_button.addEventListener('click', function (e) {
            load_overlay.style.display = 'block';
        })
    }

});
