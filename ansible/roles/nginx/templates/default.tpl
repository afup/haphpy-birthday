server {
    listen  80;

    client_max_body_size {{ upload_max_size }}m;

    root {{ doc_root }};
    server_name {{ servername }};

    # strip app.php/ prefix if it is present
    rewrite ^/app\.php/?(.*)$ /$1 permanent;

    location / {
        index app.php;
        try_files $uri @rewrite;
    }

    location @rewrite {
        rewrite ^(.*)$ /app.php/$1 last;
    }

    location ~ ^/app(_\w+)?\.php(/|$) {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS off;
    }

    error_page 404 /404.html;

    error_page 500 502 503 504 /50x.html;
        location = /50x.html {
        root /usr/share/nginx/www;
    }
}
