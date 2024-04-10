basedonnees="\n# ##> BASE DE DONNÉES \/\/ ADMINER ET mariadb\n  adminer:\n    platform: linux\/x86_64\n    container_name: adminer_\${NAME}_\${ADMINER_VERSION}\n    image: adminer:\${ADMINER_VERSION}\n    restart: unless-stopped\n    ports:\n      - \${ADMINER_LOCALHOST_PORT}:\${ADMINER_DOCKER_PORT}\n    env_file:\n      - .env\n    depends_on:\n      - database\n\n  database:\n    platform: linux\/x86_64\n    container_name: mariadb_\${NAME}_\${MARIADB_VERSION}\n    image: mariadb:\${MARIADB_VERSION}\n    restart: unless-stopped\n    env_file:\n      - .env\n    volumes:\n      - ..\/\${DATA}\/sql:\/docker-entrypoint-initdb.d\/\n      - ..\/\${MYSQL_DATA}:\/var\/lib\/mysql\n    ports:\n      - \${SQL_LOCALHOST_PORT}:\${SQL_DOCKER_PORT}\n# ##< BASE DE DONNÉES \/\/ ADMINER ET mariadb\n "

sed -i "s/image: \${IMAGES_PREFIX:-}app-php/image: backend_\${NAME}:\${BACKEND_VERSION}/g" $file_rel_compose
sed -i "/image: backend_\${NAME}:\${BACKEND_VERSION}/a \    container_name: backend_\${NAME}" $file_rel_compose
sed -i "s/HTTP_PORT/HTTP_LOCALHOST_PORT/g" $file_rel_compose
sed -i "s/HTTPS_PORT/HTTPS_LOCALHOST_PORT/g" $file_rel_compose
sed -i "s/HTTP3_PORT/HTTP3_LOCALHOST_PORT/g" $file_rel_compose
sed -i '/^ *ports: *$/,/^ *# HTTP *$/ s/^ *ports: *$/\    env_file:\n      - .env\n&/' $file_rel_compose
sed -i "s/- target: 80/- target: \${HTTP_DOCKER_PORT:-80}/g" $file_rel_compose
sed -i '/# HTTPS/{n; s/^ *- target: 443 *$/\      - target: ${HTTPS_DOCKER_PORT:-443}/}' $file_rel_compose
sed -i '/# HTTP\/3/{n; s/^ *- target: 443 *$/\      - target: ${HTTP3_DOCKER_PORT:-443}/}' $file_rel_compose
sed -i "0,/^$/ s/^$/${basedonnees}\n/" $file_rel_compose
sed -i "/\  caddy_config:/a \  ${name}_mariadb:" $file_rel_compose
sed -i "/\        protocol: udp/a \    depends_on:\n\      - database" $file_rel_compose
