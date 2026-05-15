<?php

function productImageFor($product) {
    $name = strtolower($product["product_name"] ?? "");

    $matches = [
        "pressure" => "pressure-washer.jpg",
        "washer" => "pressure-washer.jpg",
        "gasoline" => "gasoline-water-pump.jpg",
        "water pump" => "submersible-water-pump.jpg",
        "pump" => "submersible-water-pump.jpg",
        "polisher" => "polisher.jpg",
        "impact" => "impact-drill.jpg",
        "drill" => "cordless-drill.jpg",
        "auto air" => "auto-air-compressor.jpg",
        "compressor" => "air-compressor.jpg",
        "handtools" => "hand-tools-set.jpg",
        "hand tools" => "hand-tools-set.jpg",
        "tools set" => "screwdriver-pliers-kit.jpg",
        "welding" => "welding-machine.jpg",
        "grinder" => "angle-grinder.jpg",
    ];

    foreach ($matches as $keyword => $file) {
        if (strpos($name, $keyword) !== false) {
            return "assets/ai-products/" . $file;
        }
    }

    return "assets/ai-products/hand-tools-set.jpg";
}

?>
