<?php

namespace minipipo1\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class minipipo1UserBundle extends Bundle
{
        public function getParent()
        {
                return 'FOSUserBundle';
        }
}
