# Change log

## 4.1.0 (2016-06-06), @luissquall

### Bug fixes

- Fix pagination styles

### Features

- Display flash messages in admin_index (b7c96744698e59f5e3d7fb71b281dcb789ea40f4)

- Rename and update bootstrap-datepicker to version 1.3.0. Add support for `language` option (abf552b2)

  - [upgrade] Update css & js paths

- Style disabled selects

- **alert**: option dismissible to alert element (bff82b4238fb7e11c6d63d7126905edcd9335e0c)

- **alert**: Add option 'id' to alert element (507249e017687852536093244b2d1a3a10d683c2)

- Add spa time locales (ab8bd4b1)

- **users**: user profile (58e3b7736baa9c77d43926cb2c12e0345d7d6f46)

  ​

## 4.0.0 (2015-12-22), @luissquall

- **Bootstrap**

  - Upgraded Bootstrap css and js files to 3.3.6
  - **progress-bars**: Removed custom class `.progress-bar-primary`
  - **alerts**: To colorize a link inside an alert you must add the class `.alert-link` to the link. See `Templates/admin_index.ctp`
  - **alerts**: Deprecated the misspelled `.alert-dismissable` in favor of `.alert-dismissible`
  - **dropdowns**: Deprecated dropdowns `.pull-right` in favor of `.dropdown-menu-right`

- **Styles**

  - Fixed `.fancy-input-file` alignment
  - Migrated site bootstrap customization to `site/module/bootstrap.scss`. See [#820eb5c0](https://gitlab.affenbits.com/simian/simian/commit/820eb5c01471778873ba58ac021497cc686fff26)
  - **admin/core.scss**: Removed `.hidden`. Use Bootstrap `.hidden` instead (bear in mind this selector uses an `!important`)
  - **alertify**. Transformed alertify into a module (`module/alertify.scss`). See [9d945630](https://gitlab.affenbits.com/simian/simian/commit/9d945630fca3e96f0f2745b139f4db4c53160472)

- **Layouts**

  - **Admin/main.ctp**: Remove `vendor.normalize.normalize` & `vendor.bootstrap.carousel`
  - **Admin/main.ctp**: Added class `.container-fluid` to the `body` to make jumbotrons have padding

- **Views**

  - Add home page

  - **Templates/admin_dashboard**: Changed panel titles `.panel .panel-body h1.panel-title` to `.panel .panel-body h4`. By default, Bootstrap's `.panel-title` removes the bottom margin space

  - **Templates/admin_dashboard**: Added class `.small` to `.util-links`

  - **Templates/admin_dashboard**: Wrapped elements `.panel-item-icon` & `.avatar-user` around `.media-left`. See [#25dccee8](https://gitlab.affenbits.com/simian/simian/commit/25dccee87bef7e4219b4e91b6cca062944bbe5c5#41d5a9863acb98f63a626b4a6fded2c88eebd0ef_87_82)

    ​