// carreguem les llibreries
const { BasePhpTest } = require("./BasePhpTest.js");
const { By, until } = require("selenium-webdriver");
const assert = require('assert');

class LoginTest extends BasePhpTest {
    async test() {
        await this.driver.get("http://localhost:8080/login.php");

        // Comprobamos si el título de la página es correcto
        const title = await this.driver.getTitle();
        assert.strictEqual(title, "Iniciar sesión | Vota EJA", "Título de página incorrecto");

        // Introducimos las credenciales y hacemos clic en el botón de iniciar sesión
        await this.driver.findElement(By.name("userEmail")).sendKeys("ieti@iesesteveterradas.cat");
        await this.driver.findElement(By.name("pwd")).sendKeys("cordova");
        await this.driver.findElement(By.css(".btnForm")).click();

        // Esperamos a que se cargue la siguiente página
        await this.driver.wait(until.urlContains("dashboard.php"), 5000);

        // Comprobamos si la URL ha cambiado, lo que indica que el inicio de sesión fue exitoso
        const currentUrl = await this.driver.getCurrentUrl();
        assert(currentUrl.includes("dashboard.php"), "Inicio de sesión fallido");

        console.log("TEST OK");
    }
}

// ejecutamos el test
(async function test_login() {
    const test = new LoginTest();
    await test.run();
    console.log("END");
})();
