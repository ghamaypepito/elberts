<?php

namespace Brizy;


use PHPUnit\Framework\TestCase;

class DataToProjectTransformerTest extends TestCase
{


    public function executeUseCases()
    {
        return [
            ['{}'],
            ['{
  "extraFonts": [
    "fanwood_text"
  ]
}'],
            ['{
  "extraFonts": [
    "fanwood_text"
  ],
  "styles": {
    "_selected": "default",
    "_extraFontStyles": [
      {
        "deletable": "on",
        "id": "hcfdicvfev",
        "title": "New Style #10",
        "fontFamily": "noto_serif",
        "fontSize": 16,
        "fontWeight": 300,
        "lineHeight": 1.7,
        "letterSpacing": 0,
        "tabletFontSize": 15,
        "tabletFontWeight": 300,
        "tabletLineHeight": 1.6,
        "tabletLetterSpacing": 0,
        "mobileFontSize": 15,
        "mobileFontWeight": 300,
        "mobileLineHeight": 1.6,
        "mobileLetterSpacing": 0
      }
    ],
    "default": {
      "colorPalette": [
        {
          "id": "color1",
          "hex": "#191b21"
        },
        {
          "id": "color2",
          "hex": "#142850"
        },
        {
          "id": "color3",
          "hex": "#239ddb"
        },
        {
          "id": "color4",
          "hex": "#66738d"
        },
        {
          "id": "color5",
          "hex": "#bde1f4"
        },
        {
          "id": "color6",
          "hex": "#eef0f2"
        },
        {
          "id": "color7",
          "hex": "#73777f"
        },
        {
          "id": "color8",
          "hex": "#ffffff"
        }
      ],
      "fontStyles": [
        {
          "deletable": "off",
          "id": "paragraph",
          "title": "Paragraph",
          "fontFamily": "noto_serif",
          "fontSize": 16,
          "fontWeight": 300,
          "lineHeight": 1.7,
          "letterSpacing": 0,
          "tabletFontSize": 15,
          "tabletFontWeight": 300,
          "tabletLineHeight": 1.6,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 15,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.6,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "subtitle",
          "title": "Subtitle",
          "fontFamily": "noto_serif",
          "fontSize": 18,
          "fontWeight": 300,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 17,
          "tabletFontWeight": 300,
          "tabletLineHeight": 1.5,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 17,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.5,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "abovetitle",
          "title": "Above Title",
          "fontFamily": "montserrat",
          "fontSize": 16,
          "fontWeight": 400,
          "lineHeight": 1.7,
          "letterSpacing": 2,
          "tabletFontSize": 15,
          "tabletFontWeight": 400,
          "tabletLineHeight": 1.7,
          "tabletLetterSpacing": 2,
          "mobileFontSize": 13,
          "mobileFontWeight": 400,
          "mobileLineHeight": 1.7,
          "mobileLetterSpacing": 2
        },
        {
          "deletable": "off",
          "id": "heading1",
          "title": "Heading 1",
          "fontFamily": "montserrat",
          "fontSize": 56,
          "fontWeight": 200,
          "lineHeight": 1.3,
          "letterSpacing": -1.5,
          "tabletFontSize": 40,
          "tabletFontWeight": 200,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": -1,
          "mobileFontSize": 34,
          "mobileFontWeight": 200,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -1
        },
        {
          "deletable": "off",
          "id": "heading2",
          "title": "Heading 2",
          "fontFamily": "montserrat",
          "fontSize": 42,
          "fontWeight": 700,
          "lineHeight": 1.3,
          "letterSpacing": -1.5,
          "tabletFontSize": 35,
          "tabletFontWeight": 700,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": -0.5,
          "mobileFontSize": 29,
          "mobileFontWeight": 700,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -0.5
        },
        {
          "deletable": "off",
          "id": "heading3",
          "title": "Heading 3",
          "fontFamily": "montserrat",
          "fontSize": 32,
          "fontWeight": 600,
          "lineHeight": 1.3,
          "letterSpacing": -1,
          "tabletFontSize": 27,
          "tabletFontWeight": 600,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 22,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading4",
          "title": "Heading 4",
          "fontFamily": "montserrat",
          "fontSize": 26,
          "fontWeight": 500,
          "lineHeight": 1.4,
          "letterSpacing": -1,
          "tabletFontSize": 24,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 21,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading5",
          "title": "Heading 5",
          "fontFamily": "montserrat",
          "fontSize": 20,
          "fontWeight": 500,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 19,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 18,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading6",
          "title": "Heading 6",
          "fontFamily": "montserrat",
          "fontSize": 17,
          "fontWeight": 500,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 16,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 16,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "button",
          "title": "Button",
          "fontFamily": "montserrat",
          "fontSize": 12,
          "fontWeight": 600,
          "lineHeight": 1.8,
          "letterSpacing": 3,
          "tabletFontSize": 12,
          "tabletFontWeight": 600,
          "tabletLineHeight": 1.8,
          "tabletLetterSpacing": 3,
          "mobileFontSize": 12,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.8,
          "mobileLetterSpacing": 3
        }
      ]
    }
  }
}'],
            ['{
  "styles": {
    "_selected": "AlpineLodge"
  }
}'],
            ['{
  "styles": {
    "_selected": "AlpineLodge"
  },
  "extraFonts": [
    "fanwood_text"
  ]
}'],
            ['{
  "styles": {
    "_selected": "default"
  },
  "extraFonts": [
    "fanwood_text"
  ]
}'],
            ['{
  "styles": {
    "_selected": "Yoga",
    "_extraFontStyles": [
      {
        "deletable": "on",
        "id": "cldnfsvvgz",
        "title": "New Style #10",
        "fontFamily": "muli",
        "fontSize": 16,
        "fontWeight": 600,
        "lineHeight": 1.6,
        "letterSpacing": 0,
        "mobileFontSize": 15,
        "mobileFontWeight": 400,
        "mobileLineHeight": 1.6,
        "mobileLetterSpacing": 0
      }
    ],
    "Yoga": {
      "colorPalette": [
        {
          "id": "color1",
          "hex": "#1d0f23"
        },
        {
          "id": "color2",
          "hex": "#442153"
        },
        {
          "id": "color3",
          "hex": "#51d0d3"
        },
        {
          "id": "color4",
          "hex": "#9d41c8"
        },
        {
          "id": "color5",
          "hex": "#bde1f4"
        },
        {
          "id": "color6",
          "hex": "#f2fafa"
        },
        {
          "id": "color7",
          "hex": "#968fa0"
        },
        {
          "id": "color8",
          "hex": "#ffffff"
        }
      ],
      "fontStyles": [
        {
          "deletable": "off",
          "id": "paragraph",
          "title": "Paragraph",
          "fontFamily": "muli",
          "fontSize": 16,
          "fontWeight": 600,
          "lineHeight": 1.6,
          "letterSpacing": 0,
          "mobileFontSize": 15,
          "mobileFontWeight": 400,
          "mobileLineHeight": 1.6,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "subtitle",
          "title": "Subtitle",
          "fontFamily": "muli",
          "fontSize": 20,
          "fontWeight": 600,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 17,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.5,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "abovetitle",
          "title": "Above Title",
          "fontFamily": "muli",
          "fontSize": 14,
          "fontWeight": 700,
          "lineHeight": 1.7,
          "letterSpacing": 2.5,
          "mobileFontSize": 13,
          "mobileFontWeight": 400,
          "mobileLineHeight": 1.7,
          "mobileLetterSpacing": 2
        },
        {
          "deletable": "off",
          "id": "heading1",
          "title": "Heading 1",
          "fontFamily": "muli",
          "fontSize": 60,
          "fontWeight": 300,
          "lineHeight": 1.2,
          "letterSpacing": -1,
          "mobileFontSize": 34,
          "mobileFontWeight": 200,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -1
        },
        {
          "deletable": "off",
          "id": "heading2",
          "title": "Heading 2",
          "fontFamily": "yesteryear",
          "fontSize": 58,
          "fontWeight": 700,
          "lineHeight": 1.4,
          "letterSpacing": -1,
          "mobileFontSize": 40,
          "mobileFontWeight": 700,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -0.5
        },
        {
          "deletable": "off",
          "id": "heading3",
          "title": "Heading 3",
          "fontFamily": "muli",
          "fontSize": 40,
          "fontWeight": 600,
          "lineHeight": 1.3,
          "letterSpacing": 0,
          "mobileFontSize": 24,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading4",
          "title": "Heading 4",
          "fontFamily": "yesteryear",
          "fontSize": 26,
          "fontWeight": 500,
          "lineHeight": 1.4,
          "letterSpacing": -1,
          "mobileFontSize": 21,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading5",
          "title": "Heading 5",
          "fontFamily": "muli",
          "fontSize": 22,
          "fontWeight": 700,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 18,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading6",
          "title": "Heading 6",
          "fontFamily": "muli",
          "fontSize": 20,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 22,
          "mobileFontWeight": 800,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "button",
          "title": "Button",
          "fontFamily": "muli",
          "fontSize": 13,
          "fontWeight": 800,
          "lineHeight": 1.8,
          "letterSpacing": 1.5,
          "mobileFontSize": 13,
          "mobileFontWeight": 800,
          "mobileLineHeight": 1.8,
          "mobileLetterSpacing": 3
        }
      ]
    }
  },
  "extraFonts": [
    "fanwood_text"
  ]
}'],
            ['{
  "styles": {
    "_selected": "Architekt",
    "_extraFontStyles": [
      {
        "deletable": "on",
        "id": "wdzhaqavbn",
        "title": "New Style #10",
        "fontFamily": "muli",
        "fontSize": 18,
        "fontWeight": 300,
        "lineHeight": 1.6,
        "letterSpacing": 0,
        "mobileFontSize": 15,
        "mobileFontWeight": 300,
        "mobileLineHeight": 1.6,
        "mobileLetterSpacing": 0
      }
    ],
    "Swipe": {
      "colorPalette": [
        {
          "id": "color1",
          "hex": "#111112"
        },
        {
          "id": "color2",
          "hex": "#111112"
        },
        {
          "id": "color3",
          "hex": "#ff5833"
        },
        {
          "id": "color4",
          "hex": "#a7a7a7"
        },
        {
          "id": "color5",
          "hex": "#20d6eb"
        },
        {
          "id": "color6",
          "hex": "#ebebeb"
        },
        {
          "id": "color7",
          "hex": "#757575"
        },
        {
          "id": "color8",
          "hex": "#ffffff"
        }
      ],
      "fontStyles": [
        {
          "deletable": "off",
          "id": "paragraph",
          "title": "Paragraph",
          "fontFamily": "cormorant_garamond",
          "fontSize": 18,
          "fontWeight": 300,
          "lineHeight": 1.6,
          "letterSpacing": 0,
          "mobileFontSize": 15,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.6,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "subtitle",
          "title": "Subtitle",
          "fontFamily": "prata",
          "fontSize": 25,
          "fontWeight": 300,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 17,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.5,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "abovetitle",
          "title": "Above Title",
          "fontFamily": "crimson_text",
          "fontSize": 25,
          "fontWeight": 400,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 13,
          "mobileFontWeight": 400,
          "mobileLineHeight": 1.7,
          "mobileLetterSpacing": 2
        },
        {
          "deletable": "off",
          "id": "heading1",
          "title": "Heading 1",
          "fontFamily": "crimson_text",
          "fontSize": 45,
          "fontWeight": 200,
          "lineHeight": 1.7,
          "letterSpacing": 0,
          "mobileFontSize": 34,
          "mobileFontWeight": 200,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -1
        },
        {
          "deletable": "off",
          "id": "heading2",
          "title": "Heading 2",
          "fontFamily": "montserrat",
          "fontSize": 32,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 29,
          "mobileFontWeight": 700,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -0.5
        },
        {
          "deletable": "off",
          "id": "heading3",
          "title": "Heading 3",
          "fontFamily": "crimson_text",
          "fontSize": 34,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 22,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading4",
          "title": "Heading 4",
          "fontFamily": "montserrat",
          "fontSize": 30,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 21,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading5",
          "title": "Heading 5",
          "fontFamily": "playfair_display",
          "fontSize": 22,
          "fontWeight": 400,
          "lineHeight": 1.6,
          "letterSpacing": 0,
          "mobileFontSize": 18,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading6",
          "title": "Heading 6",
          "fontFamily": "montserrat",
          "fontSize": 20,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 16,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "button",
          "title": "Button",
          "fontFamily": "montserrat",
          "fontSize": 13,
          "fontWeight": 400,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 12,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.8,
          "mobileLetterSpacing": 3
        }
      ]
    }
  },
  "extraFonts": [
    "the_girl_next_door"
  ]
}'],
            ['{
  "styles": {
    "_selected": "default",
    "_extraFontStyles": [
      {
        "deletable": "on",
        "id": "wdzhaqavbn",
        "title": "New Style #10",
        "fontFamily": "muli",
        "fontSize": 18,
        "fontWeight": 300,
        "lineHeight": 1.6,
        "letterSpacing": 0,
        "mobileFontSize": 15,
        "mobileFontWeight": 300,
        "mobileLineHeight": 1.6,
        "mobileLetterSpacing": 0
      },
      {
        "deletable": "on",
        "id": "sfcwtcwbex",
        "title": "New Style #11",
        "fontFamily": "roboto",
        "fontSize": 16,
        "fontWeight": 300,
        "lineHeight": 1.7,
        "letterSpacing": 0,
        "tabletFontSize": 15,
        "tabletFontWeight": 300,
        "tabletLineHeight": 1.6,
        "tabletLetterSpacing": 0,
        "mobileFontSize": 15,
        "mobileFontWeight": 300,
        "mobileLineHeight": 1.6,
        "mobileLetterSpacing": 0
      }
    ],
    "Swipe": {
      "colorPalette": [
        {
          "id": "color1",
          "hex": "#111112"
        },
        {
          "id": "color2",
          "hex": "#111112"
        },
        {
          "id": "color3",
          "hex": "#ff5833"
        },
        {
          "id": "color4",
          "hex": "#a7a7a7"
        },
        {
          "id": "color5",
          "hex": "#20d6eb"
        },
        {
          "id": "color6",
          "hex": "#ebebeb"
        },
        {
          "id": "color7",
          "hex": "#757575"
        },
        {
          "id": "color8",
          "hex": "#ffffff"
        }
      ],
      "fontStyles": [
        {
          "deletable": "off",
          "id": "paragraph",
          "title": "Paragraph",
          "fontFamily": "cormorant_garamond",
          "fontSize": 18,
          "fontWeight": 300,
          "lineHeight": 1.6,
          "letterSpacing": 0,
          "mobileFontSize": 15,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.6,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "subtitle",
          "title": "Subtitle",
          "fontFamily": "prata",
          "fontSize": 25,
          "fontWeight": 300,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 17,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.5,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "abovetitle",
          "title": "Above Title",
          "fontFamily": "crimson_text",
          "fontSize": 25,
          "fontWeight": 400,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 13,
          "mobileFontWeight": 400,
          "mobileLineHeight": 1.7,
          "mobileLetterSpacing": 2
        },
        {
          "deletable": "off",
          "id": "heading1",
          "title": "Heading 1",
          "fontFamily": "crimson_text",
          "fontSize": 45,
          "fontWeight": 200,
          "lineHeight": 1.7,
          "letterSpacing": 0,
          "mobileFontSize": 34,
          "mobileFontWeight": 200,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -1
        },
        {
          "deletable": "off",
          "id": "heading2",
          "title": "Heading 2",
          "fontFamily": "montserrat",
          "fontSize": 32,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 29,
          "mobileFontWeight": 700,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -0.5
        },
        {
          "deletable": "off",
          "id": "heading3",
          "title": "Heading 3",
          "fontFamily": "crimson_text",
          "fontSize": 34,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 22,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading4",
          "title": "Heading 4",
          "fontFamily": "montserrat",
          "fontSize": 30,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 21,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading5",
          "title": "Heading 5",
          "fontFamily": "playfair_display",
          "fontSize": 22,
          "fontWeight": 400,
          "lineHeight": 1.6,
          "letterSpacing": 0,
          "mobileFontSize": 18,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading6",
          "title": "Heading 6",
          "fontFamily": "montserrat",
          "fontSize": 20,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 16,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "button",
          "title": "Button",
          "fontFamily": "montserrat",
          "fontSize": 13,
          "fontWeight": 400,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 12,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.8,
          "mobileLetterSpacing": 3
        }
      ]
    },
    "default": {
      "colorPalette": [
        {
          "id": "color1",
          "hex": "#191b21"
        },
        {
          "id": "color2",
          "hex": "#142850"
        },
        {
          "id": "color3",
          "hex": "#239ddb"
        },
        {
          "id": "color4",
          "hex": "#d70e8c"
        },
        {
          "id": "color5",
          "hex": "#bde1f4"
        },
        {
          "id": "color6",
          "hex": "#eef0f2"
        },
        {
          "id": "color7",
          "hex": "#73777f"
        },
        {
          "id": "color8",
          "hex": "#ffffff"
        }
      ],
      "fontStyles": [
        {
          "deletable": "off",
          "id": "paragraph",
          "title": "Paragraph",
          "fontFamily": "noto_serif",
          "fontSize": 16,
          "fontWeight": 300,
          "lineHeight": 1.7,
          "letterSpacing": 0,
          "tabletFontSize": 15,
          "tabletFontWeight": 300,
          "tabletLineHeight": 1.6,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 15,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.6,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "subtitle",
          "title": "Subtitle",
          "fontFamily": "noto_serif",
          "fontSize": 18,
          "fontWeight": 300,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 17,
          "tabletFontWeight": 300,
          "tabletLineHeight": 1.5,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 17,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.5,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "abovetitle",
          "title": "Above Title",
          "fontFamily": "montserrat",
          "fontSize": 16,
          "fontWeight": 400,
          "lineHeight": 1.7,
          "letterSpacing": 2,
          "tabletFontSize": 15,
          "tabletFontWeight": 400,
          "tabletLineHeight": 1.7,
          "tabletLetterSpacing": 2,
          "mobileFontSize": 13,
          "mobileFontWeight": 400,
          "mobileLineHeight": 1.7,
          "mobileLetterSpacing": 2
        },
        {
          "deletable": "off",
          "id": "heading1",
          "title": "Heading 1",
          "fontFamily": "montserrat",
          "fontSize": 56,
          "fontWeight": 200,
          "lineHeight": 1.3,
          "letterSpacing": -1.5,
          "tabletFontSize": 40,
          "tabletFontWeight": 200,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": -1,
          "mobileFontSize": 34,
          "mobileFontWeight": 200,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -1
        },
        {
          "deletable": "off",
          "id": "heading2",
          "title": "Heading 2",
          "fontFamily": "montserrat",
          "fontSize": 42,
          "fontWeight": 700,
          "lineHeight": 1.3,
          "letterSpacing": -1.5,
          "tabletFontSize": 35,
          "tabletFontWeight": 700,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": -0.5,
          "mobileFontSize": 29,
          "mobileFontWeight": 700,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -0.5
        },
        {
          "deletable": "off",
          "id": "heading3",
          "title": "Heading 3",
          "fontFamily": "montserrat",
          "fontSize": 32,
          "fontWeight": 600,
          "lineHeight": 1.3,
          "letterSpacing": -1,
          "tabletFontSize": 27,
          "tabletFontWeight": 600,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 22,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading4",
          "title": "Heading 4",
          "fontFamily": "montserrat",
          "fontSize": 26,
          "fontWeight": 500,
          "lineHeight": 1.4,
          "letterSpacing": -1,
          "tabletFontSize": 24,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 21,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading5",
          "title": "Heading 5",
          "fontFamily": "montserrat",
          "fontSize": 20,
          "fontWeight": 500,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 19,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 18,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading6",
          "title": "Heading 6",
          "fontFamily": "montserrat",
          "fontSize": 17,
          "fontWeight": 500,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 16,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 16,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "button",
          "title": "Button",
          "fontFamily": "montserrat",
          "fontSize": 12,
          "fontWeight": 600,
          "lineHeight": 1.8,
          "letterSpacing": 3,
          "tabletFontSize": 12,
          "tabletFontWeight": 600,
          "tabletLineHeight": 1.8,
          "tabletLetterSpacing": 3,
          "mobileFontSize": 12,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.8,
          "mobileLetterSpacing": 3
        }
      ]
    }
  },
  "extraFonts": [
    "the_girl_next_door",
    "farsan"
  ]
}'],
            ['{
  "styles": {
    "_selected": "InShape",
    "_extraFontStyles": [
      {
        "deletable": "on",
        "id": "wdzhaqavbn",
        "title": "New Style #10",
        "fontFamily": "muli",
        "fontSize": 18,
        "fontWeight": 300,
        "lineHeight": 1.6,
        "letterSpacing": 0,
        "mobileFontSize": 15,
        "mobileFontWeight": 300,
        "mobileLineHeight": 1.6,
        "mobileLetterSpacing": 0
      },
      {
        "deletable": "on",
        "id": "sfcwtcwbex",
        "title": "New Style #11",
        "fontFamily": "roboto",
        "fontSize": 16,
        "fontWeight": 300,
        "lineHeight": 1.7,
        "letterSpacing": 0,
        "tabletFontSize": 15,
        "tabletFontWeight": 300,
        "tabletLineHeight": 1.6,
        "tabletLetterSpacing": 0,
        "mobileFontSize": 15,
        "mobileFontWeight": 300,
        "mobileLineHeight": 1.6,
        "mobileLetterSpacing": 0
      }
    ],
    "Swipe": {
      "colorPalette": [
        {
          "id": "color1",
          "hex": "#111112"
        },
        {
          "id": "color2",
          "hex": "#111112"
        },
        {
          "id": "color3",
          "hex": "#ff5833"
        },
        {
          "id": "color4",
          "hex": "#a7a7a7"
        },
        {
          "id": "color5",
          "hex": "#20d6eb"
        },
        {
          "id": "color6",
          "hex": "#ebebeb"
        },
        {
          "id": "color7",
          "hex": "#757575"
        },
        {
          "id": "color8",
          "hex": "#ffffff"
        }
      ],
      "fontStyles": [
        {
          "deletable": "off",
          "id": "paragraph",
          "title": "Paragraph",
          "fontFamily": "cormorant_garamond",
          "fontSize": 18,
          "fontWeight": 300,
          "lineHeight": 1.6,
          "letterSpacing": 0,
          "mobileFontSize": 15,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.6,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "subtitle",
          "title": "Subtitle",
          "fontFamily": "prata",
          "fontSize": 25,
          "fontWeight": 300,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 17,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.5,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "abovetitle",
          "title": "Above Title",
          "fontFamily": "crimson_text",
          "fontSize": 25,
          "fontWeight": 400,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 13,
          "mobileFontWeight": 400,
          "mobileLineHeight": 1.7,
          "mobileLetterSpacing": 2
        },
        {
          "deletable": "off",
          "id": "heading1",
          "title": "Heading 1",
          "fontFamily": "crimson_text",
          "fontSize": 45,
          "fontWeight": 200,
          "lineHeight": 1.7,
          "letterSpacing": 0,
          "mobileFontSize": 34,
          "mobileFontWeight": 200,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -1
        },
        {
          "deletable": "off",
          "id": "heading2",
          "title": "Heading 2",
          "fontFamily": "montserrat",
          "fontSize": 32,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 29,
          "mobileFontWeight": 700,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -0.5
        },
        {
          "deletable": "off",
          "id": "heading3",
          "title": "Heading 3",
          "fontFamily": "crimson_text",
          "fontSize": 34,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 22,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading4",
          "title": "Heading 4",
          "fontFamily": "montserrat",
          "fontSize": 30,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 21,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading5",
          "title": "Heading 5",
          "fontFamily": "playfair_display",
          "fontSize": 22,
          "fontWeight": 400,
          "lineHeight": 1.6,
          "letterSpacing": 0,
          "mobileFontSize": 18,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading6",
          "title": "Heading 6",
          "fontFamily": "montserrat",
          "fontSize": 20,
          "fontWeight": 400,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "mobileFontSize": 16,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "button",
          "title": "Button",
          "fontFamily": "montserrat",
          "fontSize": 13,
          "fontWeight": 400,
          "lineHeight": 1.8,
          "letterSpacing": 0,
          "mobileFontSize": 12,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.8,
          "mobileLetterSpacing": 3
        }
      ]
    },
    "default": {
      "colorPalette": [
        {
          "id": "color1",
          "hex": "#191b21"
        },
        {
          "id": "color2",
          "hex": "#142850"
        },
        {
          "id": "color3",
          "hex": "#239ddb"
        },
        {
          "id": "color4",
          "hex": "#d70e8c"
        },
        {
          "id": "color5",
          "hex": "#bde1f4"
        },
        {
          "id": "color6",
          "hex": "#eef0f2"
        },
        {
          "id": "color7",
          "hex": "#73777f"
        },
        {
          "id": "color8",
          "hex": "#ffffff"
        }
      ],
      "fontStyles": [
        {
          "deletable": "off",
          "id": "paragraph",
          "title": "Paragraph",
          "fontFamily": "noto_serif",
          "fontSize": 16,
          "fontWeight": 300,
          "lineHeight": 1.7,
          "letterSpacing": 0,
          "tabletFontSize": 15,
          "tabletFontWeight": 300,
          "tabletLineHeight": 1.6,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 15,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.6,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "subtitle",
          "title": "Subtitle",
          "fontFamily": "noto_serif",
          "fontSize": 18,
          "fontWeight": 300,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 17,
          "tabletFontWeight": 300,
          "tabletLineHeight": 1.5,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 17,
          "mobileFontWeight": 300,
          "mobileLineHeight": 1.5,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "abovetitle",
          "title": "Above Title",
          "fontFamily": "montserrat",
          "fontSize": 16,
          "fontWeight": 400,
          "lineHeight": 1.7,
          "letterSpacing": 2,
          "tabletFontSize": 15,
          "tabletFontWeight": 400,
          "tabletLineHeight": 1.7,
          "tabletLetterSpacing": 2,
          "mobileFontSize": 13,
          "mobileFontWeight": 400,
          "mobileLineHeight": 1.7,
          "mobileLetterSpacing": 2
        },
        {
          "deletable": "off",
          "id": "heading1",
          "title": "Heading 1",
          "fontFamily": "montserrat",
          "fontSize": 56,
          "fontWeight": 200,
          "lineHeight": 1.3,
          "letterSpacing": -1.5,
          "tabletFontSize": 40,
          "tabletFontWeight": 200,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": -1,
          "mobileFontSize": 34,
          "mobileFontWeight": 200,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -1
        },
        {
          "deletable": "off",
          "id": "heading2",
          "title": "Heading 2",
          "fontFamily": "montserrat",
          "fontSize": 42,
          "fontWeight": 700,
          "lineHeight": 1.3,
          "letterSpacing": -1.5,
          "tabletFontSize": 35,
          "tabletFontWeight": 700,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": -0.5,
          "mobileFontSize": 29,
          "mobileFontWeight": 700,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": -0.5
        },
        {
          "deletable": "off",
          "id": "heading3",
          "title": "Heading 3",
          "fontFamily": "montserrat",
          "fontSize": 32,
          "fontWeight": 600,
          "lineHeight": 1.3,
          "letterSpacing": -1,
          "tabletFontSize": 27,
          "tabletFontWeight": 600,
          "tabletLineHeight": 1.3,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 22,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.3,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading4",
          "title": "Heading 4",
          "fontFamily": "montserrat",
          "fontSize": 26,
          "fontWeight": 500,
          "lineHeight": 1.4,
          "letterSpacing": -1,
          "tabletFontSize": 24,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 21,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading5",
          "title": "Heading 5",
          "fontFamily": "montserrat",
          "fontSize": 20,
          "fontWeight": 500,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 19,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 18,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "heading6",
          "title": "Heading 6",
          "fontFamily": "montserrat",
          "fontSize": 17,
          "fontWeight": 500,
          "lineHeight": 1.5,
          "letterSpacing": 0,
          "tabletFontSize": 16,
          "tabletFontWeight": 500,
          "tabletLineHeight": 1.4,
          "tabletLetterSpacing": 0,
          "mobileFontSize": 16,
          "mobileFontWeight": 500,
          "mobileLineHeight": 1.4,
          "mobileLetterSpacing": 0
        },
        {
          "deletable": "off",
          "id": "button",
          "title": "Button",
          "fontFamily": "montserrat",
          "fontSize": 12,
          "fontWeight": 600,
          "lineHeight": 1.8,
          "letterSpacing": 3,
          "tabletFontSize": 12,
          "tabletFontWeight": 600,
          "tabletLineHeight": 1.8,
          "tabletLetterSpacing": 3,
          "mobileFontSize": 12,
          "mobileFontWeight": 600,
          "mobileLineHeight": 1.8,
          "mobileLetterSpacing": 3
        }
      ]
    }
  },
  "extraFonts": [
    "the_girl_next_door",
    "farsan"
  ]
}']
        ];
    }

    /**
     * @throws \Exception
     */
    public function testInvalidExecuteContext()
    {
        $this->expectException(\Exception::class);
        $context = new DataToProjectContext("", "./tests/_data/editor-build");
        $transformer = new DataToProjectTransformer();
        $transformer->execute($context);
    }

    /**
     * @dataProvider executeUseCases
     */
    public function testExecute($json)
    {
        $context = new DataToProjectContext(json_decode($json), "./tests/_data/editor-build");
        $this->internalExecute($json, $context);
    }

    /**
     * @dataProvider executeUseCases
     */
    public function testExecute2($json)
    {
        $context = new DataToProjectContext(json_decode($json), "./tests/_data/editor-build2");
        $this->internalExecute($json, $context);
    }

    /**
     * @param $array
     * @param $property
     * @param $value
     */
    private function assertObjectsFromArrayHasProperty($array, $property, $value, $message = "does not have property")
    {
        $existed = false;
        foreach ($array as $data) {
            if (is_object($data) && isset($data->$property) && $data->$property === $value) {
                $existed = true;
            }
        }

        $this->assertTrue($existed, $message);
    }

    /**
     * @param $json
     * @param DataToProjectContext $context
     */
    protected function internalExecute($json, DataToProjectContext $context): void
    {
        $transformer = new DataToProjectTransformer();

        $data = $transformer->execute($context);

        // SelectedKit
        $this->assertTrue(isset($data->selectedKit), "It should contain selectedKit");

        // SelectedStyle
        $this->assertTrue(isset($data->selectedStyle), "It should contain selectedStyle");

        // Styles
        $this->assertTrue(isset($data->styles), "It should contain styles");

        $this->assertObjectsFromArrayHasProperty($data->styles, "id", $data->selectedStyle, "The style " . $data->selectedStyle . " is missing from styles");

        // ExtraFonts && ExtraFontStyles
        $oldData = json_decode($json);

        if (isset($oldData->extraFonts)) {
            $this->assertTrue(isset($data->fonts->google), "It should contain Fonts -> Google");

            foreach ($oldData->extraFonts as $fontKey) {
                $hasFonts = false;

                foreach ($data->fonts->google->data as $font) {
                    $fontFamilyToKey = preg_replace('/\s+/', '_', strtolower($font->family));

                    if ($fontKey === $fontFamilyToKey) {
                        $hasFonts = true;
                    }
                }

                $this->assertTrue($hasFonts, "It should contain font " . $fontKey);
            }
        }

        // ExtraFontStyles
        if (isset($oldData->styles) && isset($oldData->styles->_extraFontStyles)) {
            $this->assertTrue(isset($data->extraFontStyles), "It should contain ExtraStyles");
        }
    }
}

