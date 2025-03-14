<?php
namespace Ethanrobins\Chatbridge\Language;

class LangPair
{
    private Lang $lang;
    private string $string;

    public function __construct(Lang $lang, string $string = "")
    {
        $this->lang = $lang;
        $this->string = $string;
    }

    public function getLang(): Lang
    {
        return $this->lang;
    }

    public function getString(): string
    {
        return $this->string;
    }

    public function setString(string $string): LangPair
    {
        $this->string = $string;
        return $this;
    }
}