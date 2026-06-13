function Convert-LightMode($file) {
    $content = Get-Content $file -Raw -Encoding UTF8
    $content = $content -replace 'bg-dark', 'bg-white shadow-sm'
    $content = $content -replace 'text-light', 'text-dark'
    $content = $content -replace 'border-secondary', 'border-light'
    $content = $content -replace 'text-light-50', 'text-secondary'
    Set-Content -Path $file -Value $content -Encoding UTF8
}

Convert-LightMode 'C:\Users\buidi\Downloads\web-php-main\web-php-main\views\home\index.php'
Convert-LightMode 'C:\Users\buidi\Downloads\web-php-main\web-php-main\views\movie\detail.php'
Convert-LightMode 'C:\Users\buidi\Downloads\web-php-main\web-php-main\views\news\index.php'
Convert-LightMode 'C:\Users\buidi\Downloads\web-php-main\web-php-main\views\cinemas\index.php'
Convert-LightMode 'C:\Users\buidi\Downloads\web-php-main\web-php-main\views\payment\index.php'

# Navbar
$nav = 'C:\Users\buidi\Downloads\web-php-main\web-php-main\views\partials\navbar.php'
$c = Get-Content $nav -Raw -Encoding UTF8
$c = $c -replace 'navbar-dark bg-black border-bottom border-secondary', 'navbar-light bg-white border-bottom border-light shadow-sm'
$c = $c -replace 'form-control bg-dark border-secondary text-light', 'form-control bg-light border-light text-dark'
$c = $c -replace 'dropdown-menu dropdown-menu-dark dropdown-menu-end', 'dropdown-menu dropdown-menu-end'
$c = $c -replace 'nav-link text-light me-3', 'nav-link text-dark me-3'
Set-Content -Path $nav -Value $c -Encoding UTF8

# Layout
$lay = 'C:\Users\buidi\Downloads\web-php-main\web-php-main\views\layouts\main.php'
$c = Get-Content $lay -Raw -Encoding UTF8
$c = $c -replace 'data-bs-theme="dark"', 'data-bs-theme="light"'
Set-Content -Path $lay -Value $c -Encoding UTF8
