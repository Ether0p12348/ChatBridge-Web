<?php

namespace Ethanrobins\Chatbridge\Config;

/**
 * Represents the type of configuration item in the system.
 */
enum Type: string
{
    case ROOT = "root";
    case PAGE = "page";
    case SECTION = "section";


}
