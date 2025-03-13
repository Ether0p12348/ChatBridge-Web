<?php

namespace Ethanrobins\Chatbridge\Language;

use Ethanrobins\Chatbridge\Exception\LanguageException;
use Lang;
use LangPair;
use ReflectionClass;

class LangSet
{
    private LangPair $bg;
    private LangPair $zh_CN;
    private LangPair $zh_TW;
    private LangPair $hr;
    private LangPair $cs;
    private LangPair $da;
    private LangPair $nl;
    private LangPair $en_GB;
    private LangPair $en_US;
    private LangPair $fi;
    private LangPair $fr;
    private LangPair $de;
    private LangPair $el;
    private LangPair $hi;
    private LangPair $hu;
    private LangPair $id;
    private LangPair $it;
    private LangPair $ja;
    private LangPair $ko;
    private LangPair $lt;
    private LangPair $no;
    private LangPair $pl;
    private LangPair $pt_BR;
    private LangPair $ro;
    private LangPair $ru;
    private LangPair $es_ES;
    private LangPair $es_419;
    private LangPair $sv;
    private LangPair $th;
    private LangPair $tr;
    private LangPair $uk;
    private LangPair $vi;

    /**
     * @param Lang $lang
     * @param string $string
     * @return $this
     * @throws LanguageException
     */
    public function set(Lang $lang, string $string): LangSet
    {
        if ($lang !== Lang::UNKNOWN) {
            $this->{str_replace('-', "_", $lang->getLocale())} = new LangPair($lang, $string);
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
            return $this->en_US;
        } else {
            return $this->{str_replace('-', "_", $lang->getLocale())};
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