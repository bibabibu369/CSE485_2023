<?php
use PHPUnit\Framework\TestCase;

<?php

class LoginPageTest extends TestCase
{
    private $dom;

    protected function setUp(): void
    {
        $html = file_get_contents('/C:/xampp/htdocs/Workspace/btth02/views/user/login.php');
        $this->dom = new DOMDocument();
        @$this->dom->loadHTML($html);
    }

    public function testRememberMeCheckboxExists()
    {
        $xpath = new DOMXPath($this->dom);
        $checkbox = $xpath->query("//div[contains(@class, 'row align-items-center remember')]/input[@type='checkbox']");

        $this->assertEquals(1, $checkbox->length, "Remember Me checkbox should exist.");
    }
}
?>