/* Init */
checkerInitialization();

/* Generic form checker > Listener */
function checkerInitialization() {

    $("form").each(function() {

        if(this.getAttribute("data-form-checker") !== null && this.getAttribute("data-form-checker") === "true") {

            //Global listener for checker and submit allowed / not-allowed.
            $(this).on("submit", function(e) {
                e.preventDefault();
                formChecker(this);
            });

            //Listeners for check inputs.
            $(this).find("input,textarea").each(function() {
                $(this).on("focusout", function() {
                    inputElementChecker(this);
                });
            });
            $(this).find("focusout").each(function() {
                $(this).on("focusout", function() {
                    inputElementChecker(this);
                });
            });

        }
    });
}

function inputElementChecker(inputElt) {
    if(inputElt.getAttribute("data-form-checker") !== null) {

        let inputValue = inputElt.value;
        let errorParagraphElt = inputElt.parentNode.getElementsByClassName("inputError")[0];

        if(errorParagraphElt !== undefined) {

            let errorTextElt = errorParagraphElt.getElementsByTagName("span")[0];
            let checkTypes = inputElt.getAttribute("data-form-checker").split(",");
            let name = inputElt.getAttribute("data-name");
            if(name === null) {
                name = "";
            }
            let errorCounter = 0;

            if(checkTypes.length > 0) {
                checkTypes.forEach(function(element) {

                    let checker = element.split("_");
                    let checkerName = checker[0];
                    let checkerArgument = null;
                    if(checker.length > 0) {
                        checkerArgument = checker[1];
                    }

                    switch(checkerName) {

                        case "email":
                            if(validateEmail(inputValue) !== true) {
                                errorTextElt.innerHTML = name + " invalid format";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "notEmpty":
                            if(inputValue.length === 0) {
                                errorTextElt.innerHTML = name + " cannot be empty";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "boolean":
                            if(inputValue !== 'true' || inputValue !== 'false') {
                                errorTextElt.innerHTML = name + " have to be true or false.";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "positiveInteger":
                            if(Number(inputValue) < 0) {
                                errorTextElt.innerHTML = name + " have to be positive";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "sameAsPrevious":
                            let previousInput = inputElt.parentNode.previousElementSibling.getElementsByTagName("input")[0];
                            if(previousInput.value !== inputValue) {
                                errorTextElt.innerHTML = name + " is not similar";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "captcha":
                            let rep = grecaptcha.getResponse();
                            if(rep.length === 0) {
                                errorTextElt.innerHTML = "We love robots, but...";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "maxLength":
                            if(Number(inputValue.length) > Number(checkerArgument)) {
                                errorTextElt.innerHTML = name + " can't have more of " + checkerArgument + " characters";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "minLength":
                            if(Number(inputValue.length) < Number(checkerArgument)) {
                                errorTextElt.innerHTML = name + " can't have less of " + checkerArgument + " characters";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "maxInt":
                            if(Number(inputValue) > Number(checkerArgument)) {
                                errorTextElt.innerHTML = name + " can't be > to " + checkerArgument + ".";
                                inputElt.classList.add("error");
                                errorCounter ++;
                            }
                            break;

                        case "userAlreadyExists":
                            launchAjaxRequest("?mode=Front&module=AccountCreation&ajax=login_constraint_checker&login=" + inputValue, function(response) {
                                if(JSON.parse(response) === true) {
                                    errorTextElt.innerHTML = "User name already exists";
                                    inputElt.classList.add("error");
                                    errorCounter ++;
                                }
                            });
                            break;

                    }
                });

            }

            if(errorCounter === 0) {
                inputElt.classList.remove("error");
            }

        }

    }

}

function formChecker(formElt) {
    $(formElt).find("input,textarea").each(function() {
        inputElementChecker(this);
    });
    let errorCounter = $(formElt).find("input.error, select.error, textarea.error").length;
    if(errorCounter === 0) {
        formElt.submit();
    }
}

function validateEmail(email) {
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}


/* A DÉPLACER AILLEURS */
function launchAjaxRequest(url, callback) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            if(callback !== false) {
                callback(xhr.responseText);
            }
        }
    };
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(null);
}

// $("#gameCreationForm").on("submit", function() {
//     let submit = $("#gameCreationPostAction");
//     submit.attr("disabled", true);
// });