let username = "";
let password = "";
let email = "";
let phone = "";
let country = "";
let city = "";
let postalCode = "";
let countries = "";

let countryData = {}

$(function() {
    showStep();
})

function showStep(step = 0, animate = true) {
    switch (step) {
        case 0:
            $("form").append(`
                <div class="inputContainer">
                    <label for="username">Nombre de usuario: </label>
                    <input type="text" id="username" name="username">
                </div>
            `)
            $("#username").on('input', function() {
                $(`form > div:gt(${step})`).remove()
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let username = $("#username").val()
                        if (username == "") {
                            showNotification('error', 'Inserte un nombre de usuario')
                        } else {
                            showStep(step+1)
                        }
                        return false;
                    }
                });
            }).focus()
            break;
        case 1:
            $("form").append(`
                <div class="inputContainer">
                    <label for="password">Contraseña: </label>
                    <input type="password" id="password" name="password">
                </div>
            `)
            $("#password").on('input', function() {
                $(`form > div:gt(${step})`).remove()
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let password = $("#password").val()
                        if (password.length < 8) {
                            showNotification("error", "La contraseña debe tener un mínimo de 8 carácteres")
                        } else if (password.includes(";") || password.includes("--") || password.includes("/*") || password.includes("*/")) {
                            showNotification("error", "La contraseña contiene carácteres no permitidos")
                        } else if (!/\d/.test(password)) { /* if password doesn't contain numbers */
                            showNotification("error", "La contraseña debe contener al menos un carácter numérico")
                        } else if (!/[A-Z]/g.test(password)) { /* if password doesn't contain uppercase letters */
                            showNotification("error", "La contraseña debe contener al menos una mayúscula")
                        } else if (!/[a-z]/g.test(password)) { /* if password doesn't contain lowercase letters */
                            showNotification("error", "La contraseña debe contener al menos una minúscula")
                        } else if (!/[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(password)) {/* if password doesn't contain special characters */
                            showNotification("error", "La contraseña debe contener al menos un carácter especial")
                        } else {
                            showStep(step+1)
                        }
                        return false;
                    }
                });
            }).focus()
            break;
        case 2:
            $("form").append(`
                <div class="inputContainer">
                    <label for="password2">Confirme la contraseña: </label>
                    <input type="password" id="password2" name="password2">
                </div>
            `)
            $("#password2").on('input', function() {
                $(`form > div:gt(${step})`).remove()
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let password = $("#password").val();
                        let password2 = $("#password").val();
                        if (password != password2) {
                            showNotification("error", "Las contraseñas no coinciden")
                        } else {
                            showStep(step+1)
                        }
                        return false;
                    }
                });
            }).focus()
            break;
        case 3:
            $("form").append(`
                <div class="inputContainer">
                    <label for="email">Correo electrónico: </label>
                    <input type="email" id="email" name="email">
                </div>
            `)
            $("#email").on('input', function() {
                $(`form > div:gt(${step})`).remove()
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let email = $("#email").val()
                        if (!email.toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) { /* if email address is not valid */
                            showNotification("error", "La dirección de correo electrónico no es válida")
                        } else {
                            showStep(step+1)
                        }
                        return false;
                    }
                });
            }).focus()
            break;
        case 4:
            $("form").append(`
                <div class="inputContainer">
                    <label for="phone">Introduzca su número de teléfono (con prefijo y sin espacios): </label>
                    <input type="tel" id="phone" name="phone">
                </div>
            `)
            $("#phone").on('input', function() {
                $(`form > div:gt(${step})`).remove()
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let phone = $("#phone").val()
                        if (!/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im.test(phone)) {
                            showNotification("error", "El número de teléfono insertado no es válido")
                        } else  if (Number.isInteger(phone) || phone.includes(";") || phone.includes("--") || phone.includes("/*") || phone.includes("*/")) {
                            showNotification("error", "El número de teléfono insertado contiene carácteres no permitidos")
                        } else {
                            showStep(step+1)
                        }
                    }
                });
            }).focus()
            break;
        case 5:
            let formString = `
            <div class="inputContainer">
                <label for="country">País: </label>
                <div class="sel sel--black-panther">
                <select id="country" name="country">`;
            let countryNames = Object.keys(countryData)
            for (let i = 0; i < countryNames.length; i++) {
                formString += `<option>${countryNames[i]}</option>`
            }
            formString += "</select></div></div>"
            $("form").append(formString)
            $("#country").on('input', function() {
                country = $("#country").find(":selected").text();
                $(`form > div:gt(${step})`).remove()
                if (country == "") {
                    showNotification("error", "Inserte un país") 
                } else if (country.includes(";") || country.includes("--") || country.includes("/*") || country.includes("*/")) {
                    showNotification("error", "El país insertado contiene carácteres no permitidos")
                } else {
                    showStep(step+1)
                }
            }).focus()
            break;
        case 6:

            $("form").append(`
                <div class="inputContainer">
                    <label for="city">Ciudad: </label>
                    <input type="text" id="city" name="city">
                </div>
            `)
            $("#city").on('input', function() {
                $(`form > div:gt(${step})`).remove()
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let city = $("#city").val()
                        if (city.length == "") {
                            showNotification("error", "Inserte una ciudad") 
                        } else if (city.includes(";") || city.includes("--") || city.includes("/*") || city.includes("*/")) {
                            showNotification("error", "La ciudad insertada contiene carácteres no permitidos")
                        } else {
                            showStep(step+1)
                        }
                    }
                });
            }).focus()
            break;
        case 7:
            $("form").append(`
                <div class="inputContainer">
                    <label for="postalCode">Código Postal: </label>
                    <input type="text" id="postalCode" name="postalCode">
                </div>
            `)
            $(window).off("keydown.custom")
            $("#postalCode").on('input', function() {
                $(`form > div:gt(${step})`).remove()
                let postalCode = $("#postalCode").val()
                $(window).off("keydown.custom").on("keydown.custom", function(event) {
                    if (event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        if (/^[a-zA-Z]+$/.test($("#postalCode").val())) {
                            showNotification('error', "El código postal indicado no es válido")
                        } else {
                            $("form").append(`
                            <div class="inputContainer">
                                <input type="submit" value="Crear usuario" class="btn2" id="registerSubmit">
                            </div>
                        `)
                        }
                    } 
                })
                }).focus()
            break;
    }
    $(window).off("keydown.custom").on("keydown.custom", function(event) {
        if(event.keyCode == 13 || event.keyCode == 9) {
            event.preventDefault();
            return false;
        }
    })
}

function getCountryData(dataFromPHP) {
    countryData = dataFromPHP
    console.log(dataFromPHP)
}

// Function to submit form since AJAX is not alllowed
function submitForm() {
    $("form").html(`
        <input type="hidden" name="username" value="${username}">
        <input type="hidden" name="password" value="${password}">
        <input type="hidden" name="email" value="${email}">
        <input type="hidden" name="phone" value="${phone}">
        <input type="hidden" name="country" value="${country}">
        <input type="hidden" name="city" value="${city}">
        <input type="hidden" name="postalCode" value="${postalCode}">
    `).submit();
}