<?php

namespace App\Tests\Security;

use App\Security\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testTokenGeneration(): void
    {
        $tokenGen = new TokenGenerator();
        $token = $tokenGen->getRandomSecureToken(30);
//        $token[15] = '*';
//        echo $token;

        $this->assertEquals(30, \strlen($token));
        $this->assertTrue(ctype_alnum($token), 'Token contains incorrect characters');
    }
}
