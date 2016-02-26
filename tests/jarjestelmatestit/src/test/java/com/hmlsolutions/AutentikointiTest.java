package com.hmlsolutions;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.testng.Assert;
import org.testng.annotations.*;

import java.net.MalformedURLException;
import java.net.URL;

public class AutentikointiTest {

    private final String USERNAME = "buhmen";
    private final String ACCESS_KEY = System.getenv("SAUCE_ACCESS_KEY");
    private final String URL = "http://" + USERNAME + ":" + ACCESS_KEY + "@ondemand.saucelabs.com:80/wd/hub";

    private WebDriver driver;

    @BeforeClass
    public void setup() {
        if (ACCESS_KEY != null) {
            DesiredCapabilities caps = DesiredCapabilities.chrome();
            caps.setCapability("platform", "Windows XP");
            caps.setCapability("version", "43.0");

            try {
                driver = new RemoteWebDriver(new URL(URL), caps);
            } catch (MalformedURLException e) {
                System.err.println("SAUCE URL ON VIRHEELLINEN");
            }
        }
        else {
            driver = new FirefoxDriver();
        }
    }

    @Test
    public void kirjauduOpettajana_paadyOpettajanSivulle() throws Exception {
        driver.get("http://hmlsolutions.com/ryhma2/sivu/public_html");

        driver.findElement(By.name("tunnus")).sendKeys("55555");
        driver.findElement(By.name("salasana")).sendKeys("12345");

        driver.findElement(By.name("salasana")).submit();

        Assert.assertNotNull(driver.findElement(By.id("omaKalenteriLinkki")), "Päädytyllä sivulla ei ole linkkiä" +
                " omaan kalenteriin");
        Assert.assertEquals(driver.findElements(By.id("hallintaSivunLinkki")).size(), 1,
                "Päädytyllä sivulla ei ole linkkiä aikojen hallintaan vaikka pitäisi");
    }

    @Test
    public void kirjauduOpiskelijana_paadyOpiskelijanSivulle() {
        driver.get("http://hmlsolutions.com/ryhma2/sivu/public_html");

        driver.findElement(By.name("tunnus")).sendKeys("55555");
        driver.findElement(By.name("salasana")).sendKeys("12345");

        driver.findElement(By.name("salasana")).submit();

        Assert.assertNotNull(driver.findElement(By.id("omaKalenteriLinkki")), "Päädytyllä sivulla ei ole linkkiä" +
                " omaan kalenteriin");
        Assert.assertEquals(driver.findElements(By.id("hallintaSivunLinkki")).size(), 0,
                "Päädytyllä sivulla on linkki aikojen hallintaan vaikka ei pitäisi");
    }

    @Test
    public void kirjauduVaarallaTunnuksella_paadyKirjautumissivulle() {
        driver.get("http://hmlsolutions.com/ryhma2/sivu/public_html");

        driver.findElement(By.name("tunnus")).sendKeys("vaara_tunnus");
        driver.findElement(By.name("salasana")).sendKeys("vaara_salasana");

        driver.findElement(By.name("salasana")).submit();

        Assert.assertTrue(driver.getTitle().equals("Ajanvaraus kirjautuminen"),
                "Päädytyllä sivulla ei ole otsikkoa 'Ajanvaraus kirjautuminen'");
    }

    @AfterMethod
    public void logout() {
        driver.get("http://hmlsolutions.com/ryhma2/sivu/public_html/logout.php");
    }

    @AfterClass
    public void tearDown() {
        driver.quit();
    }
}
