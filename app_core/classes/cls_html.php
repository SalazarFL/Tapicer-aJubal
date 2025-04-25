<?php
class cls_Html {

    // Genera una etiqueta <script> para JS
    public function html_js_header(string $script_path): string {
        return "<script src='{$script_path}'></script>\n";
    }

    // Genera una etiqueta <link> para CSS
    public function html_css_header(string $css_path, string $media): string {
        return "<link rel='stylesheet' type='text/css' href='{$css_path}' media='{$media}'>\n";
    }

    // Formulario - apertura
    public function html_form_tag(string $id, string $class, string $action, string $method): string {
        return "<form id='{$id}' class='{$class}' action='{$action}' method='{$method}'>\n";
    }

    // Formulario - cierre
    public function html_form_end(): string {
        return "</form>\n";
    }

    // Input de texto
    public function html_input_text(string $type, string $name, string $id, string $class, string $value, string $placeholder, string $required): string {
        return "<input type='{$type}' name='{$name}' id='{$id}' class='{$class}' value='{$value}' placeholder='{$placeholder}' {$required}>\n";
    }

    // Select
    public function html_select(string $name, string $id, string $class, array $options, string $selected, string $required): string {
        $select = "<select name='{$name}' id='{$id}' class='{$class}' {$required}>\n";

        foreach ($options as $value => $text) {
            $isSelected = ($value === $selected) ? "selected" : "";
            $select .= "<option value='{$value}' {$isSelected}>{$text}</option>\n";
        }

        $select .= "</select>\n";
        return $select;
    }

    // Textarea
    public function html_textarea(string $name, string $id, string $class, string $value, string $placeholder, int $rows, string $required): string {
        return "<textarea name='{$name}' id='{$id}' class='{$class}' placeholder='{$placeholder}' rows='{$rows}' {$required}>{$value}</textarea>\n";
    }

    // Botón
    public function html_button(string $type, string $name, string $id, string $class, string $value, string $icon): string {
        return "<button type='{$type}' name='{$name}' id='{$id}' class='{$class}'><i class='{$icon}'></i> {$value}</button>\n";
    }

    // Input oculto
    public function html_hidden(string $name, string $id, string $value): string {
        return "<input type='hidden' name='{$name}' id='{$id}' value='{$value}'>\n";
    }

    // Estrellas de calificación (de 1 a 5)
    public function html_rating_stars(string $name, int $selected, string $required): string {
        $html = "<div class='rating-stars'>\n";

        for ($i = 5; $i >= 1; $i--) {
            $isChecked = ($i == $selected) ? "checked" : "";
            $html .= "<input type='radio' id='{$name}_{$i}' name='{$name}' value='{$i}' {$isChecked} {$required}>\n";
            $html .= "<label for='{$name}_{$i}' title='{$i} estrellas'><i class='fas fa-star'></i></label>\n";
        }

        $html .= "</div>\n";
        return $html;
    }
}
?>
