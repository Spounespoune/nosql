# Démarre les conteneurs en arrière-plan
up:
	docker-compose up -d

# Arrête les conteneurs
down:
	docker-compose down

# Redémarre les conteneurs
restart:
	docker-compose down
	docker-compose up -d

# Affiche les logs des conteneurs
logs:
	docker-compose logs -f

logs-nginx:
	docker logs nginx -f

logs-phpfpm:
	docker logs phpfpm -f

# Supprime les conteneurs, les réseaux et les volumes
clean:
	docker-compose down -v

remove-images:
	docker rmi $(docker images -a -q)

# Reconstruit les images et redémarre les conteneurs
build:
	docker-compose up -d --build

status:
	docker-compose ps -a

nginx:
	docker exec -it nginx bash

fpm:
	docker exec -it phpfpm bash