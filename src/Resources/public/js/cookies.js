import Alert from "../../../../assets/js/Alert";
import Loader from "../../../../assets/js/Loader";

const cookiesFormContainer = document.getElementById('cookies-form-container');

const hideContainer = () => {
    const $cookiesContainer = $('#cookies');
    const $window = $(window);
    const cookiesContainerHeight = $cookiesContainer.outerHeight();
    const cookiesBottomOffset = ($window.height() + $window.scrollTop()) - (cookiesContainerHeight + $cookiesContainer.offset().top);
    $cookiesContainer.animate({bottom: -(cookiesContainerHeight + cookiesBottomOffset)}, 'slow', () => {
        $cookiesContainer.remove();
    })
};

const cookiesContainer = document.querySelector('#cookies_accept');

if(cookiesContainer !== null){
    cookiesContainer.addEventListener('click', (event) => {
        fetch(Routing.generate("accept_cookies_action"), {
            method: 'post',
            credentials: 'same-origin',
            headers: new Headers({
                'X-Requested-With': 'XMLHttpRequest'
            })
        }).then((resp) => {
            return resp.text()
        }).then((resp) => {
            if (resp !== 'ok') {
                throw new Error('Error');
            }
            hideContainer();

        }).catch((error) => {
            Alert.errorMessage(error);
        });
    });
}

const showCookieSettings = document.querySelector('#show-cookie-settings');
if(showCookieSettings !== null){
    showCookieSettings.addEventListener('click', (event) => {
        Loader.loaderOn();
        fetch(Routing.generate('build_cookies_form'), {
            method: 'post',
            headers: new Headers({
                'X-Requested-With': 'XMLHttpRequest'
            })
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(response.status);
                }

                return response.json();
            })
            .then((data) => {
                cookiesFormContainer.innerHTML = data.form;

                document.getElementById('submit-cookies-settings').addEventListener('click', (event) => {
                    submitCookiesSettingsForm();
                });

                Loader.loaderOff();
            })
            .catch((error) => {
                Alert.errorMessage(error);

                Loader.loaderOff();
            });
    });
}



let submitCookiesSettingsForm = function () {
    Loader.loaderOn();
    let formData = new FormData(document.querySelector('#cookies_settings_form'));

    fetch(Routing.generate('cookies_validate'), {
        method: 'post',
        credentials: 'same-origin',
        headers: new Headers({
            'X-Requested-With': 'XMLHttpRequest'
        }),
        body: formData
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.status);
            }

            return response.json();
        })
        .then((data) => {
            if (data.ok) {
                cookiesFormContainer.innerHTML = '';
                hideContainer();
            } else {
                if (data.form) {
                    cookiesFormContainer.innerHTML = data.form;
                }else{
                    Alert.successMessage(data.error);
                }
            }
            Loader.loaderOff();
        })
        .catch((error) => {
            Alert.errorMessage(error);

            Loader.loaderOff();
        });
};
