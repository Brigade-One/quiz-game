<?php
namespace Server\Models;

class Theme
{
    private $themeID;
    private $name;
    private $imgURL;

    public function __construct(
        ?string $themeID,
        string $name,
        string $imgURL
    ) {
        $this->themeID = $themeID;
        $this->name = $name;
        $this->imgURL = $imgURL;
    }

    public function getThemeID(): ?string
    {
        return $this->themeID;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getImgURL(): string
    {
        return $this->imgURL;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setImgURL(string $imgURL): void
    {
        $this->imgURL = $imgURL;
    }
}