# CSS Classes


## Documentation
Introducing the **Bugfish CSS Framework** – a solution for efficient web design. Simplify your development process with a comprehensive collection of pre-built classes, designed to expedite the creation of responsive web layouts. The Bugfish CSS Framework streamlines your design experience, making it faster and more professional. To use it, include the CSS files located in the `css` folder.

**Add `_f` to end of a class to make it important!**

## Library

### Column/Rows

| Class         | Description                                         |
|---------------|-----------------------------------------------------|
| `.xfpe_row`   | Row Element (Put Col Elements in it to be placed next to each other) |
| `.xfpe_col`   | Row Element without width configuration            |
| `.xfpe_col-1` | Row Element 1/12 width                              |
| `.xfpe_col-2` | Row Element 2/12 width                              |
| `.xfpe_col-3` | Row Element 3/12 width                              |
| `.xfpe_col-4` | Row Element 4/12 width                              |
| `.xfpe_col-5` | Row Element 5/12 width                              |
| `.xfpe_col-6` | Row Element 6/12 width                              |
| `.xfpe_col-7` | Row Element 7/12 width                              |
| `.xfpe_col-8` | Row Element 8/12 width                              |
| `.xfpe_col-9` | Row Element 9/12 width                              |
| `.xfpe_col-10`| Row Element 10/12 width                             |
| `.xfpe_col-11`| Row Element 11/12 width                             |
| `.xfpe_col-12`| Row Element 12/12 width                             |

### Background Colors

| Class                | Description                             | Possible Values                                              |
|----------------------|-----------------------------------------|--------------------------------------------------------------|
| `.xfpe_background*`  | Sets Background Color (Replace `*` with possible value) | red, yellow, green, blue, orange, purple, pink, brown, black, white, gray, cyan, magenta, lime |
| `.xfpe_background*_f`| Forces Background Color (Replace `*` with possible value) | red, yellow, green, blue, orange, purple, pink, brown, black, white, gray, cyan, magenta, lime |

### Text Colors

| Class               | Description                       | Possible Values                                              |
|---------------------|-----------------------------------|--------------------------------------------------------------|
| `.xfpe_color*`      | Sets Text Color (Replace `*` with possible value) | red, yellow, green, blue, orange, purple, pink, brown, black, white, gray, cyan, magenta, lime |
| `.xfpe_color*_f`    | Forces Text Color (Replace `*` with possible value) | red, yellow, green, blue, orange, purple, pink, brown, black, white, gray, cyan, magenta, lime |

### Margin Classes

| Padding / Margin Class       | Description                                               | Possible Values | Max Value of N |
|------------------------------|-----------------------------------------------------------|-----------------|----------------|
| `.xfpe_paddingauto`           | Sets padding to "auto" for all sides                       |                 |                |
| `.xfpe_nopadding`            | Removes padding from all sides (sets to 0px)             |                 |                |
| `.xfpe_nopaddingtop`         | Removes padding from the top (sets padding-top to 0px)   |                 |                |
| `.xfpe_nopaddingbottom`      | Removes padding from the bottom (sets padding-bottom to 0px) |                 |                |
| `.xfpe_nopaddingleft`        | Removes padding from the left (sets padding-left to 0px) |                 |                |
| `.xfpe_nopaddingright`       | Removes padding from the right (sets padding-right to 0px) |                 |                |
| `.xfpe_paddingleft{N}px`     | Sets the left padding of the element to N pixels.         | N: 5, 10, 15, ... | 150            |
| `.xfpe_paddingright{N}px`    | Sets the right padding of the element to N pixels.        | N: 5, 10, 15, ... | 150            |
| `.xfpe_paddingleftm{N}px`    | Sets a negative left padding of the element to N pixels.  | N: 5, 10, 15, ... | 150            |
| `.xfpe_paddingrightm{N}px`   | Sets a negative right padding of the element to N pixels. | N: 5, 10, 15, ... | 150            |
| `.xfpe_paddingbottom{N}px`   | Sets padding-bottom to a specific value in pixels (Xpx)   | N: 5, 10, 15, ... | 150            |
| `.xfpe_paddingbottomm{N}px`  | Sets negative padding-bottom to a specific value in pixels (-Xpx) | N: 5, 10, 15, ... | 150            |
| `.xfpe_paddingtop{N}px`      | Sets padding-top to a specific value in pixels (Xpx)      | N: 5, 10, 15, ... | 150            |
| `.xfpe_paddingtopm{N}px`     | Sets negative padding-top to a specific value in pixels (-Xpx) | N: 5, 10, 15, ... | 150            |
| `.xfpe_marginauto`           | Sets margin to "auto" for all sides                       |                 |                |
| `.xfpe_nomargin`             | Removes margin from all sides (sets to 0px)              |                 |                |
| `.xfpe_nomargintop`          | Removes margin from the top (sets margin-top to 0px)      |                 |                |
| `.xfpe_nomarginbottom`       | Removes margin from the bottom (sets margin-bottom to 0px) |                 |                |
| `.xfpe_nomarginleft`         | Removes margin from the left (sets margin-left to 0px)   |                 |                |
| `.xfpe_nomarginright`        | Removes margin from the right (sets margin-right to 0px) |                 |                |
| `.xfpe_marginleft{N}px`      | Sets the left margin of the element to N pixels.          | N: 5, 10, 15, ... | 150            |
| `.xfpe_marginright{N}px`     | Sets the right margin of the element to N pixels.         | N: 5, 10, 15, ... | 150            |
| `.xfpe_marginleftm{N}px`     | Sets a negative left margin of the element to N pixels.   | N: 5, 10, 15, ... | 150            |
| `.xfpe_marginrightm{N}px`    | Sets a negative right margin of the element to N pixels.  | N: 5, 10, 15, ... | 150            |
| `.xfpe_margintop{N}px`       | Sets the top margin of the element to N pixels.           | N: 5, 10, 15, ... | 150            |
| `.xfpe_margintopm{N}px`      | Sets negative margin-top to a specific value in pixels (-Xpx) | N: 5, 10, 15, ... | 150            |
| `.xfpe_marginbottom{N}px`    | Sets margin-bottom to a specific value in pixels (Xpx)    | N: 5, 10, 15, ... | 150            |
| `.xfpe_marginbottomm{N}px`   | Sets negative margin-bottom to a specific value in pixels (-Xpx) | N: 5, 10, 15, ... | 150            |

### Width/Height Classes

| Width / Height Class   | Description                            | Possible Values | Max Value of N |
|------------------------|----------------------------------------|-----------------|----------------|
| `.xfpe_width{N}px`     | Sets the element's width to N pixels.   | N: 25, 50, 75, 100, ... | 1000           |
| `.xfpe_height{N}px`    | Sets the element's height to N pixels.  | N: 25, 50, 75, 100, ... | 1000           |
| `.xfpe_width{N}pct`    | Sets the element's width to N percentage. | N: 25, 50, 75, 100, ... | 100            |
| `.xfpe_height{N}pct`   | Sets the element's height to N percentage. | N: 25, 50, 75, 100, ... | 100            |
| `.xfpe_maxwidth{N}pct` | Sets the element's width to N percentage of parent. | N: 25, 50, 100 | 100            |
| `.xfpe_maxwidth{N}px`  | Sets the maximum width of the element to N pixels. | N: 50, 100, 150, ... | 1000           |
| `.xfpe_minwidth{N}px`  | Sets the minimum width of the element to N pixels. | N: 50, 100, 150, ... | 1000           |
| `.xfpe_minwidth{N}pct` | Sets the minimum width of the element to N percentage of parent. | N: 25, 50, 75, 100, ... | 100            |

### Font Size

| Font Size Class         | Description                                | Possible Values | Max Value of N |
|-------------------------|--------------------------------------------|-----------------|----------------|
| `.xfpe_fontsize{N}px`   | Sets font size to N pixels.                | N: 10, 20, 30, 40, 50, ... | 100            |
| `.xfpe_fontsize{N}pct`  | Sets font size to N percentage.            | N: 25, 50, 75, 100, ... | 100            |

### Display

| Class Name            | Description                             |
|-----------------------|-----------------------------------------|
| `.xfpe_dispinlineblock` | `display: inline-block;`                |
| `.xfpe_dispinline`     | `display: inline;`                      |
| `.xfpe_dispblock`      | `display: block;`                       |
| `.xfpe_dispnone`       | `display: none;` (Hides the element)    |
| `.xfpe_dispflex`       | `display: flex;` (Enables flexbox layout)|
| `.xfpe_dispgrid`       | `display: grid;` (Enables grid layout)  |
| `.xfpe_dispinlineflex` | `display: inline-flex;` (Inline flexbox layout) |
| `.xfpe_dispinlinegrid` | `display: inline-grid;` (Inline grid layout) |

### Float

| Class Name              | Description                                        |
|-------------------------|----------------------------------------------------|
| `.xfpe_floatleft`       | `float: left;`                                    |
| `.xfpe_floatleft_f`     | `float: left !important;`                         |
| `.xfpe_floatright`      | `float: right;`                                   |
| `.xfpe_floatright_f`    | `float: right !important;`                        |
| `.xfpe_floatnone`       | `float: none;` (Clears any previous float)        |
| `.xfpe_floatinherit`    | `float: inherit;` (Inherits the float property)   |
| `.xfpe_floatinitial`    | `float: initial;` (Sets to default value)         |
| `.xfpe_floatunset`      | `float: unset;` (Resets to inherited value)       |

### Overflow

| Class Name               | Description                                         |
|--------------------------|-----------------------------------------------------|
| `.xfpe_overflowhidden`   | `overflow: hidden;`                                |
| `.xfpe_overflowhidden_f` | `overflow: hidden !important;`                     |
| `.xfpe_overflowscroll`   | `overflow: scroll;`                               |
| `.xfpe_overflowscroll_f` | `overflow: scroll !important;`                    |
| `.xfpe_overflowvisible`  | `overflow: visible;` (Shows content overflowing)   |
| `.xfpe_overflowauto`     | `overflow: auto;` (Adds scrollbars if needed)      |
| `.xfpe_overflowxhidden`  | `overflow-x: hidden;`                             |
| `.xfpe_overflowxhidden_f`| `overflow-x: hidden !important;`                  |
| `.xfpe_overflowxscroll`  | `overflow-x: scroll;`                             |
| `.xfpe_overflowxscroll_f`| `overflow-x: scroll !important;`                  |
| `.xfpe_overflowyhidden`  | `overflow-y: hidden;`                             |
| `.xfpe_overflowyhidden_f`| `overflow-y: hidden !important;`                  |
| `.xfpe_overflowyscroll`  | `overflow-y: scroll;`                             |
| `.xfpe_overflowyscroll_f`| `overflow-y: scroll !important;`                  |


### Text Adjustments

| Class Name                | Description                                      |
|---------------------------|--------------------------------------------------|
| `.xfpe_textbreakall`      | `white-space: pre; word-break: break-all;`      |
| `.xfpe_textbreakall_f`    | `white-space: pre !important; word-break: break-all !important;` |
| `.xfpe_textnowrap`        | `white-space: nowrap;`                          |
| `.xfpe_textnowrap_f`      | `white-space: nowrap !important;`               |
| `.xfpe_textuppercase`     | `text-transform: uppercase;`                    |
| `.xfpe_textuppercase_f`   | `text-transform: uppercase !important;`         |
| `.xfpe_textlowercase`     | `text-transform: lowercase;`                    |
| `.xfpe_textlowercase_f`   | `text-transform: lowercase !important;`         |
| `.xfpe_textcapitalize`    | `text-transform: capitalize;`                   |
| `.xfpe_textcapitalize_f`  | `text-transform: capitalize !important;`        |

### Align Adjustments

| Class Name                   | Description                                   |
|------------------------------|-----------------------------------------------|
| `.xfpe_aligncenter`          | `text-align: center;`                        |
| `.xfpe_aligncenter_f`        | `text-align: center !important;`             |
| `.xfpe_alignleft`            | `text-align: left;`                          |
| `.xfpe_alignleft_f`          | `text-align: left !important;`               |
| `.xfpe_alignright`           | `text-align: right;`                         |
| `.xfpe_alignright_f`         | `text-align: right !important;`              |
| `.xfpe_alignjustify`         | `text-align: justify;`                       |
| `.xfpe_alignjustify_f`       | `text-align: justify !important;`            |
| `.xfpe_verticalalignmiddle`  | `vertical-align: middle;`                    |
| `.xfpe_verticalalignmiddle_f`| `vertical-align: middle !important;`         |
| `.xfpe_verticalaligntop`     | `vertical-align: top;`                       |
| `.xfpe_verticalaligntop_f`   | `vertical-align: top !important;`            |
| `.xfpe_verticalalignbottom`  | `vertical-align: bottom;`                    |
| `.xfpe_verticalalignbottom_f`| `vertical-align: bottom !important;`         |
| `.xfpe_alignbaseline`        | `vertical-align: baseline;`                  |
| `.xfpe_alignbaseline_f`      | `vertical-align: baseline !important;`       |

### Cursor

| Class Name             | Description                                        |
|------------------------|----------------------------------------------------|
| `.xfpe_cursorpointer`  | `cursor: pointer;`                                |
| `.xfpe_cursorpointer_f`| `cursor: pointer !important;`                     |
| `.xfpe_cursordefault`  | `cursor: default;` (Default cursor, usually an arrow) |
| `.xfpe_cursorauto`     | `cursor: auto;` (Automatically sets cursor based on the element) |
| `.xfpe_cursorcrosshair`| `cursor: crosshair;` (Crosshair cursor)           |
| `.xfpe_cursorhelp`     | `cursor: help;` (Help cursor, usually a question mark) |
| `.xfpe_cursormove`     | `cursor: move;` (Move cursor)                     |
| `.xfpe_cursornotallowed`| `cursor: not-allowed;` (Not-allowed cursor)       |
| `.xfpe_cursorprogress` | `cursor: progress;` (Progress cursor)            |
| `.xfpe_cursortext`     | `cursor: text;` (Text cursor, usually an I-beam)  |
| `.xfpe_cursorwait`     | `cursor: wait;` (Wait cursor)                     |
| `.xfpe_cursoralias`    | `cursor: alias;` (Alias cursor)                   |
| `.xfpe_cursorcopy`     | `cursor: copy;` (Copy cursor)                     |
| `.xfpe_cursorzoomin`   | `cursor: zoom-in;` (Zoom-in cursor)               |
| `.xfpe_cursorzoomout`  | `cursor: zoom-out;` (Zoom-out cursor)            |
| `.xfpe_cursorgrab`     | `cursor: grab;` (Grab cursor)                     |
| `.xfpe_cursorgrabbing` | `cursor: grabbing;` (Grabbing cursor)           |

### Border

| Class Name         | Description                       |
|--------------------|-----------------------------------|
| `.xfpe_bordernone` | `border: none;`                   |
| `.xfpe_bordernone_f` | `border: none !important;`      |
| `.xfpe_outlinenone` | `outline: none;`                 |
| `.xfpe_outlinenone_f` | `outline: none !important;`    |

### Position

| Class Name          | Description                           |
|---------------------|---------------------------------------|
| `.xfpe_absolute`    | `position: absolute;`                 |
| `.xfpe_absolute_f`  | `position: absolute !important;`      |
| `.xfpe_fixed`       | `position: fixed;`                    |
| `.xfpe_fixed_f`     | `position: fixed !important;`         |
| `.xfpe_relative`    | `position: relative;`                 |
| `.xfpe_relative_f`  | `position: relative !important;`      |
| `.xfpe_static`      | `position: static;`                   |
| `.xfpe_static_f`    | `position: static !important;`        |
| `.xfpe_sticky`      | `position: sticky;`                   |
| `.xfpe_sticky_f`    | `position: sticky !important;`        |

### Optimization

| Class Name           | Description                                                |
|----------------------|------------------------------------------------------------|
| `.xfpe_t3d`          | `-webkit-transform: translate3d(0, 0, 0); transform: translate3d(0, 0, 0);` (Enables hardware acceleration) |
| `.xfpe_t3d_f`        | `-webkit-transform: translate3d(0, 0, 0) !important; transform: translate3d(0, 0, 0) !important;` (Enables hardware acceleration with `!important`) |
| `.xfpe_borderbox`    | `-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;` (Includes padding and border in element's total width and height) |
| `.xfpe_borderbox_f`  | `-webkit-box-sizing: border-box !important; -moz-box-sizing: border-box !important; box-sizing: border-box !important;` (Includes padding and border in element's total width and height with `!important`) |
