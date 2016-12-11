# Shopify Special Offers Bundle (Embed)

## Installation

**Install With Composer**

```json
{
   "require": {
       "sturple/fgms-shopify-forms": "dev-master"
   }
}

```

and then execute

```json
$ composer update
```


## Configuration

**Add to ```app/AppKernel.php``` file**

```php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            ...
             new Fgms\EmailInquiriesBundle\FgmsEmailInquiriesBundle();
        ]
    }
}

```

The following configuration options may/must be set in `config.yml`:

```yaml
fgms_email_inquiries:
    api_key:            # API key for Shopify
    secret:             # Secret for Shopify
```

## Shopify App Configuration

The bundle specifies the following routes which must be known to configure as a Shopify App:

- **Install:** `/install`
- **OAuth:** `/auth`
- **Home:** `/`

To setup a Shopify proxy for form submission point the proxy at `/submit`.  The unique code for the form to submit to should be appended to the Shopify proxy link.
