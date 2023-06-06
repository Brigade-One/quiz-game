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

    public function toJSON()
    {
        return json_encode([
            'themeID' => $this->themeID,
            'name' => $this->name,
            'imgURL' => $this->imgURL,
        ]);
    }
    public static function fromJSON(array $json): Theme
    {
        return new Theme(
            $json['themeID'],
            $json['name'],
            $json['imgURL'],
        );
    }
}