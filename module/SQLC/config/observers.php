<?php

namespace SQLC;

use SQLC\Model\Observer\Terminal;

return [
    Terminal::EVENT => [new Terminal(), 'execute']
];