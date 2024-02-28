// carreguem les llibreries
const { BasePhpTest } = require("./BasePhpTest.js");
const { By, until } = require("selenium-webdriver");
const { Key } = require("selenium-webdriver");
const assert = require('assert');

// heredem una classe amb un sol mètode test()
// emprem this.driver per utilitzar Selenium

class CompleteWorkflowTest extends BasePhpTest {
    async test() {
        // Iniciar sesión con el primer usuario
        await this.login("ieti@iesesteveterradas.cat", "cordova");

        // Ir a newPoll.php a través de un botón
        await this.driver.findElement(By.id("createQuestion")).click();

        // Crear una encuesta
        await this.createPoll("¿Qué opinas sobre el cambio climático?", ["A favor", "En contra"], "2024-02-22 11:30", "2024-02-23 11:30");

        // Hacer logout
        await this.logout();

        // Iniciar sesión con el segundo usuario
        await this.login("asoldado_ieti@iesesteveterradas.cat", "cordova");

        // Ir a list_polls.php
        await this.driver.get("http://localhost:8080/list_polls.php");

        // Comprobar que no hay ninguna encuesta creada
        const pollElements = await this.driver.findElements(By.className("poll"));
        assert.strictEqual(pollElements.length, 0, "Se encontraron encuestas creadas");

        console.log("TEST OK");
    }

    async login(email, password) {
        await this.driver.get("http://localhost:8080/login.php");
        await this.driver.findElement(By.name("userEmail")).sendKeys(email);
        await this.driver.findElement(By.name("pwd")).sendKeys(password);
        await this.driver.findElement(By.css(".btnForm")).click();
        await this.driver.wait(until.urlContains("dashboard.php"), 5000);
    }

    async createPoll(question, answers, startDate, endDate) {
        const questionInput = await this.driver.findElement(By.name("question"));
        await questionInput.sendKeys(question);
        
        // Simular presionar la tecla TAB para activar el botón "addAnswer"
        await questionInput.sendKeys(Key.TAB);
    
        // Agregar respuestas
        for (let i = 0; i < answers.length; i++) {
            const placeholder = `Respuesta ${i + 1}`;
            const answerInput = await this.driver.findElement(By.xpath(`//input[@placeholder="${placeholder}"]`));
            
            // Agregar respuesta
            await answerInput.sendKeys(answers[i]);
    
            // Simular presionar la tecla ENTER para agregar la respuesta y activar el botón "addAnswer" para la siguiente respuesta
            await this.driver.actions().sendKeys(Key.ENTER).perform();
        }
    
        const startDateInput = await this.driver.findElement(By.name("dateStart"));
        await startDateInput.sendKeys(startDate);
    
        const endDateInput = await this.driver.findElement(By.name("dateFinish"));
        await endDateInput.sendKeys(endDate);
        await this.driver.actions().sendKeys(Key.ENTER).perform();

    
        // Esperar a que el botón de guardar cambios esté habilitado
        await this.driver.wait(until.elementLocated(By.id("saveChanges")), 5000);
        await this.driver.findElement(By.id("saveChanges")).click();
    
        // Esperar a que la página de dashboard se cargue después de enviar el formulario
        await this.driver.wait(until.urlContains("dashboard.php"), 5000);
    }
    
    async logout() {
        await this.driver.get("http://localhost:8000/logout.php");
        await this.driver.wait(until.urlContains("index.php"), 5000);
    }
}

// ejecutamos el test
(async function test_complete_workflow() {
    const test = new CompleteWorkflowTest();
    await test.run();
    console.log("END");
})();