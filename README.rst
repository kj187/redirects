Random notes
============
- Support GeoIP based on http://dev.maxmind.com/geoip/mod_geoip2 .
- Detects client language based on browser settings.
- If multiple redirects available for a URL the redirect with most matching 
  attributes like "country code", "client language" and "device" will do the match.
- Extension is compatible with TYPO3 4.6.x up to latest TYPO3 6.x

Additional Improvements
============
- Support typoLink for target URL
- Target "domain" could be used optional?
    - In this case all possible target domains needs to be configured somhow.
- Add IP whitelist
- Implement IP wildcard support on whitelist and blacklist
- Performance tuning
    - Avoid using extbase.
- Module to find conflicting redirect records.
