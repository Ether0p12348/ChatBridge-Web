<?php

namespace Ethanrobins\Chatbridge\Language;

use Ethanrobins\Chatbridge\Exception\LanguageException;
use ReflectionClass;

class LangSet
{
    private LangPair $bulgarian;
    private LangPair $chinese_china;
    private LangPair $chinese_taiwan;
    private LangPair $croatian;
    private LangPair $czech;
    private LangPair $danish;
    private LangPair $dutch;
    private LangPair $english_uk;
    private LangPair $english_us;
    private LangPair $finnish;
    private LangPair $french;
    private LangPair $german;
    private LangPair $greek;
    private LangPair $hindi;
    private LangPair $hungarian;
    private LangPair $indonesian;
    private LangPair $italian;
    private LangPair $japanese;
    private LangPair $korean;
    private LangPair $lithuanian;
    private LangPair $norwegian;
    private LangPair $polish;
    private LangPair $portuguese_brazilian;
    private LangPair $romanian_romania;
    private LangPair $russian;
    private LangPair $spanish;
    private LangPair $spanish_latam;
    private LangPair $swedish;
    private LangPair $thai;
    private LangPair $turkish;
    private LangPair $ukrainian;
    private LangPair $vietnamese;

    /**
     * @param Lang $lang
     * @param string $string
     * @return $this
     * @throws LanguageException
     */
    public function set(Lang $lang, string $string): LangSet
    {
        if ($lang !== Lang::UNKNOWN) {
            $this->{strtolower($lang->name)} = new LangPair($lang, $string);
        } else {
            throw new LanguageException("You cannot set an unknown language");
        }
        return $this;
    }

    /**
     * @param Lang $lang
     * @return string
     */
    public function get(Lang $lang): LangPair
    {
        if ($lang === Lang::UNKNOWN) {
            return $this->english_us;
        } else {
            return $this->{strtolower($lang->name)};
        }
    }

    public function __toString(): string
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        $pairs = array();
        foreach ($properties as $p) {
            $value = $p->getValue($this);

            if ($value instanceof LangPair) {
                $pairs[$value->getLang()->name] = $value->getString();
            }
        }

        return print_r($pairs, true);
    }
}