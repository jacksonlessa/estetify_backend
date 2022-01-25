echo "
CREATE DATABASE IF NOT EXISTS \`estetify_backend_test\`;
GRANT ALL PRIVILEGES ON \`estetify_backend_test\`.* TO '$MYSQL_USER'@'%';
" | docker_process_sql