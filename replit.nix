{ pkgs }: {
    deps = [
        pkgs.php
        pkgs.phpPackages.composer
        pkgs.mysql
        pkgs.mysql-client
    ];
} 