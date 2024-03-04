const errors = {
    email: {
        message: "Email must be in the format johndoe@gmail.com",
        elem: document.getElementById('email'),
        reg: /^[\S]+@[a-zA-Z]+\.[a-zA-Z]+$/,
        errorElem: document.getElementById('email-error')
    },
    password: {
        message: "Password must be 8 characters",
        elem: document.getElementById('password'),
        reg: /^.{8,}$/,
        errorElem: document.getElementById('password-error')
    },
    password2: {
        message: "Passwords must match",
        elem: document.getElementById('passwordConfirm'),
        errorElem: document.getElementById('confirm-password-error')
    }
};

const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');

const validateForm = (e) => {

    // returns false if any of the fields are invalid
    let formState = true;
    // test if email is not valid and outputs error if invalid
    if (!errors.email.reg.test(errors.email.elem.value)) {
        errors.email.errorElem.innerHTML = errors.email.message;
        formState = false;
    }

    // test if password is not valid and outputs error if invalid
    if (!errors.password.reg.test(errors.password.elem.value)) {
        errors.password.errorElem.innerHTML = errors.password.message;
        formState = false;
    }

    // test if password match and output error if not
    if (errors.password.elem.value !== errors.password2.elem.value) {
        errors.password2.errorElem.innerHTML = errors.password2.message;
        formState = false;
    }


    return formState;
}

const validateLogin = () => {
    // returns false if any of the fields are invalid
    let formState = true;
    // test if email is not valid and outputs error if invalid
    if (!errors.email.reg.test(errors.email.elem.value)) {
        errors.email.errorElem.innerHTML = errors.email.message;
        formState = false;
    }

    // test if password is not valid and outputs error if invalid
    if (!errors.password.reg.test(errors.password.elem.value)) {
        errors.password.errorElem.innerHTML = errors.password.message;
        formState = false;
    }

    // test if password match and outputs error if invalid
    if (errors.password.elem.value !== errors.password2.elem.value) {
        errors.password2.errorElem.innerHTML = errors.password2.message;
        formState = false;
    }

    return formState;
}


// Validates a specific field when the text changes. Can be used for email or password
const validateField = (fieldObj) => {
    if (!fieldObj.reg.test(fieldObj.elem.value)) {
        fieldObj.errorElem.innerHTML = fieldObj.message;
    } else {
        fieldObj.errorElem.innerHTML = "";
    }

}
// Add event listeners for dynamic single input error checking
email.addEventListener('input', () => {
    validateField(errors.email);
});

password.addEventListener('input', () => {
    validateField(errors.password);
})