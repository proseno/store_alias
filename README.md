This module was developed for adding in url custom path that will highlight the store view without changing Nginx configuration.
It allows to specify similar alias for different store views which are then will differ by domain name.

For example, https://jewerly.test/en or https://jewerly.test/ar and https://shampoo.test/en or https://shampoo.test/ar

This module extends the default Magento 2 functionality and allow to change store code to alias.
Path to the default configuration: <ins>_Stores -> Configuration -> General -> Web -> Url Options -> Add Store Code to Urls_</ins>

This feature has switcher that can be found by configuration path: <ins>_Stores -> Configuration -> General -> Proseno Store Alias -> General settings -> Enable_</ins>

The actual alias can be set in store view form following the path: <ins>_Stores -> All Stores -> 'Choose the store view' -> Alias_</ins>
