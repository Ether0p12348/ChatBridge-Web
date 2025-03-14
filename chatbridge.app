# THIS IS SAVED HERE PURELY FOR STORING (chatbridge.app nginx site configuration)

# Main server block
server {
    listen 443 ssl;
    server_name chatbridge.app;

    root /var/www/chatbridge.app/src;
    index index.php index.html index.htm;

    error_log /var/log/nginx/error.log debug;

    # SSL Registration
    ssl_certificate /etc/letsencrypt/live/chatbridge.app/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/chatbridge.app/privkey.pem; # managed by Certbot
    include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot

    # Redirect to uri without index or index.php if present
    if ($request_uri ~* ^(.*/)(index(?:\.php)?)$) {
        return 301 $1;
    }
    # rewrite any ISO 3166-1 formatted first directives to the url without it, extending the $args
    rewrite "^/([a-zA-Z]{2}([-_][a-zA-Z0-9]{0,5})?)(/.*)?$" "/$3?$args&lang=$1" last;
    # Try in order:
    # 1. The file with extension (redirected to extensionless via conditional above)
    # 2. The directory (if index.php is present)
    # 3. @extensionless
    # 4. If no static file exists, use @markdown
    location / {
        try_files $uri $uri/ @extensionless @markdown;
    }
    # Rewrites .php extension URI to extensionless URI
    location @extensionless {
        rewrite ^/(.+)$ /$1.php?$args last;
    }
    # Rewrites .md extension URI to extensionless .md -> /markdown_driver.php?file=URI
    # - Will not produce errors if the .md file doesn't exist. Must be handled in /markdown_driver.php
    location @markdown {
	    rewrite ^/(.*)$ /markdown_driver.php?$args&file=$1.md last;
    }
    # fastcgi-php init
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }
    # Disallows direct access to /markdown_driver.php (overridden by @markdown)
    location /markdown_driver.php {
        internal;
    }
    # Disallows access to .ht* files
    location ~ /\.ht {
        deny all;
    }
    # Disallows access to .md files (gives http_error_code 403)
    location ~ \.md$ {
        deny all;
    }

}

# If 'www.' is present, redirect to root
server {
    listen 443 ssl;
    server_name www.chatbridge.app;
    return 301 https://chatbridge.app$request_uri;
}

# If request is http root or 'www.', redirect to https root
server {
    listen 80;
    server_name chatbridge.app www.chatbridge.app;
    return 301 https://chatbridge.app$request_uri;
}