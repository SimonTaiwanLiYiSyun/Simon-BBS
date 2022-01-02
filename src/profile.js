
function setInputError(inputElement, message) {
    inputElement.classList.add("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = message;
}

function clearInputError(inputElement) {
    inputElement.classList.remove("form__input--error")
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = "";
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".form__input").forEach(inputElement => {
        inputElement.addEventListener("keyup", e => {
            if (e.target.id === "confirmPassword" && signuppassword.value != confirmpassword.value) {
                setInputError(inputElement, "Confirm password must same with password.");
            }
            else if(e.target.id === "confirmPassword" && signuppassword.value == confirmpassword.value) {
                clearInputError(inputElement);
            }
        });

        inputElement.addEventListener("input", e => {
            clearInputError(inputElement);
        });
    });
});
