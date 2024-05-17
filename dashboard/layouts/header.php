<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SI Penjadwalan</title>

    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png" />

    <link rel="stylesheet" href="./assets/compiled/css/app.css" />
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css" />
    <link rel="stylesheet" href="./assets/custom/css/style.css">

    <script src="./assets/static/js/components/dark.js"></script>
    <script src="./assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="./assets/compiled/js/app.js"></script>

    <!-- Need: Apexcharts -->
    <script src="./assets/extensions/apexcharts/apexcharts.min.js"></script>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="index.html"><img src="./assets/compiled/svg/logo.svg" alt="Logo" srcset="" /></a>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item active">
                            <a href="index.html" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-stack"></i>
                                <span>Components</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="component-accordion.html" class="submenu-link">Accordion</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-alert.html" class="submenu-link">Alert</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-badge.html" class="submenu-link">Badge</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-breadcrumb.html" class="submenu-link">Breadcrumb</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-button.html" class="submenu-link">Button</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-card.html" class="submenu-link">Card</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-carousel.html" class="submenu-link">Carousel</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-collapse.html" class="submenu-link">Collapse</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-dropdown.html" class="submenu-link">Dropdown</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-list-group.html" class="submenu-link">List Group</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-modal.html" class="submenu-link">Modal</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-navs.html" class="submenu-link">Navs</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-pagination.html" class="submenu-link">Pagination</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-progress.html" class="submenu-link">Progress</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-spinner.html" class="submenu-link">Spinner</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-toasts.html" class="submenu-link">Toasts</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="component-tooltip.html" class="submenu-link">Tooltip</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-collection-fill"></i>
                                <span>Extra Components</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="extra-component-avatar.html" class="submenu-link">Avatar</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="extra-component-divider.html" class="submenu-link">Divider</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="extra-component-date-picker.html" class="submenu-link">Date Picker</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="extra-component-sweetalert.html" class="submenu-link">Sweet Alert</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="extra-component-toastify.html" class="submenu-link">Toastify</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="extra-component-rating.html" class="submenu-link">Rating</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Layouts</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="layout-default.html" class="submenu-link">Default Layout</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="layout-vertical-1-column.html" class="submenu-link">1 Column</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="layout-vertical-navbar.html" class="submenu-link">Vertical Navbar</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="layout-rtl.html" class="submenu-link">RTL Layout</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="layout-horizontal.html" class="submenu-link">Horizontal Menu</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Forms &amp; Tables</li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-hexagon-fill"></i>
                                <span>Form Elements</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="form-element-input.html" class="submenu-link">Input</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="form-element-input-group.html" class="submenu-link">Input Group</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="form-element-select.html" class="submenu-link">Select</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="form-element-radio.html" class="submenu-link">Radio</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="form-element-checkbox.html" class="submenu-link">Checkbox</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="form-element-textarea.html" class="submenu-link">Textarea</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a href="form-layout.html" class="sidebar-link">
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Form Layout</span>
                            </a>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-journal-check"></i>
                                <span>Form Validation</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="form-validation-parsley.html" class="submenu-link">Parsley</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-pen-fill"></i>
                                <span>Form Editor</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="form-editor-quill.html" class="submenu-link">Quill</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="form-editor-ckeditor.html" class="submenu-link">CKEditor</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="form-editor-summernote.html" class="submenu-link">Summernote</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="form-editor-tinymce.html" class="submenu-link">TinyMCE</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a href="table.html" class="sidebar-link">
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Table</span>
                            </a>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                                <span>Datatables</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="table-datatable.html" class="submenu-link">Datatable</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="table-datatable-jquery.html" class="submenu-link">Datatable (jQuery)</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Extra UI</li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-pentagon-fill"></i>
                                <span>Widgets</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="ui-widgets-chatbox.html" class="submenu-link">Chatbox</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="ui-widgets-pricing.html" class="submenu-link">Pricing</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="ui-widgets-todolist.html" class="submenu-link">To-do List</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-egg-fill"></i>
                                <span>Icons</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="ui-icons-bootstrap-icons.html" class="submenu-link">Bootstrap Icons
                                    </a>
                                </li>

                                <li class="submenu-item">
                                    <a href="ui-icons-fontawesome.html" class="submenu-link">Fontawesome</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="ui-icons-dripicons.html" class="submenu-link">Dripicons</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>Charts</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="ui-chart-chartjs.html" class="submenu-link">ChartJS</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="ui-chart-apexcharts.html" class="submenu-link">Apexcharts</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a href="ui-file-uploader.html" class="sidebar-link">
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                                <span>File Uploader</span>
                            </a>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-map-fill"></i>
                                <span>Maps</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="ui-map-google-map.html" class="submenu-link">Google Map</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="ui-map-jsvectormap.html" class="submenu-link">JS Vector Map</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-three-dots"></i>
                                <span>Multi-level Menu</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item has-sub">
                                    <a href="#" class="submenu-link">First Level</a>

                                    <ul class="submenu submenu-level-2">
                                        <li class="submenu-item">
                                            <a href="ui-multi-level-menu.html" class="submenu-link">Second Level</a>
                                        </li>

                                        <li class="submenu-item">
                                            <a href="#" class="submenu-link">Second Level Menu</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu-item has-sub">
                                    <a href="#" class="submenu-link">Another Menu</a>

                                    <ul class="submenu submenu-level-2">
                                        <li class="submenu-item">
                                            <a href="#" class="submenu-link">Second Level Menu</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Pages</li>

                        <li class="sidebar-item">
                            <a href="application-email.html" class="sidebar-link">
                                <i class="bi bi-envelope-fill"></i>
                                <span>Email Application</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="application-chat.html" class="sidebar-link">
                                <i class="bi bi-chat-dots-fill"></i>
                                <span>Chat Application</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="application-gallery.html" class="sidebar-link">
                                <i class="bi bi-image-fill"></i>
                                <span>Photo Gallery</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="application-checkout.html" class="sidebar-link">
                                <i class="bi bi-basket-fill"></i>
                                <span>Checkout Page</span>
                            </a>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Authentication</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="auth-login.html" class="submenu-link">Login</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="auth-register.html" class="submenu-link">Register</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="auth-forgot-password.html" class="submenu-link">Forgot Password</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-x-octagon-fill"></i>
                                <span>Errors</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="error-403.html" class="submenu-link">403</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="error-404.html" class="submenu-link">404</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="error-500.html" class="submenu-link">500</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Raise Support</li>

                        <li class="sidebar-item">
                            <a href="https://zuramai.github.io/mazer/docs" class="sidebar-link">
                                <i class="bi bi-life-preserver"></i>
                                <span>Documentation</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="https://github.com/zuramai/mazer/blob/main/CONTRIBUTING.md" class="sidebar-link">
                                <i class="bi bi-puzzle"></i>
                                <span>Contribute</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="https://github.com/zuramai/mazer#donation" class="sidebar-link">
                                <i class="bi bi-cash"></i>
                                <span>Donate</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>