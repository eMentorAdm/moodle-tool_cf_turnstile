# Moodle Local Plugin for Cloudflare Turnstile

This Moodle plugin integrates Cloudflare Turnstile into your site, providing enhanced protection against spam and abuse. By using Cloudflare Turnstile, this plugin ensures a secure and seamless user experience during the signup process.

## Installation

1. **Download and Install the Plugin:**
   - Download the plugin files and place them in the appropriate directory in your Moodle installation (e.g., `your_moodle_directory/local/turnstile`).
   - Navigate to the Site Administration area of your Moodle site.
   - Go to `Site administration -> Plugins -> Install plugins` and follow the prompts to complete the installation.

2. **Configure Cloudflare Turnstile Keys:**
   - Navigate to `Site administration -> Server -> Cloudflare Turnstile`.
   - Enter the required Cloudflare Turnstile credentials (Site Key and Secret Key), which you can obtain from the [Cloudflare Turnstile site](https://www.cloudflare.com/products/turnstile/).
   - Select the desired theme (light or dark).
   - Save your changes.

## Configuration

After the initial setup, the plugin requires minimal configuration:

- **Turnstile Settings:**
  - Ensure that the Site Key and Secret Key are correctly entered in the settings page.
  - Choose the theme that best fits your site's design (light or dark).
  - Save your settings to apply the changes.

## Usage

Once configured, the Cloudflare Turnstile will appear on the user signup form, providing an added layer of security against automated bot signups. The Turnstile widget will render based on the selected theme, ensuring a cohesive look with your site.

## Troubleshooting

- **Error Messages:**
  - If users encounter issues during signup related to Turnstile validation, double-check the Site Key and Secret Key.
  - Ensure that your Moodle site can communicate with the Cloudflare Turnstile service (internet connectivity is required).

- **Widget Visibility:**
  - If the Turnstile widget is not appearing on the signup form, verify that the plugin is enabled and configured correctly in the settings page.

## Contributing

We welcome contributions to improve this plugin. Please submit issues or pull requests via the [GitHub repository](https://github.com/eMentorAdm/moodle-tool_cf_turnstile).

