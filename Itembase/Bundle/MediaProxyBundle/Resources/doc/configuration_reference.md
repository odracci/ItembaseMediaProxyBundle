ItembaseMediaProxyBundle Configuration Reference
==========================================

Below a list of all possible config values including their default values:

``` yaml
# app/config/config.yml
itembase_media_proxy:
    algorithm: sha1 # hashing algorithm to use [optional]
    secret: ThisTokenIsNotSecretChangeIt # secret for hashing
    ignore_https: false # flag if https domains shall be ignored [optional]
    prefix_path:  # path which is generated before local paths [optional]
```