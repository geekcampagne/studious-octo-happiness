SAIL=./vendor/bin/sail
build:
	cp .env.example .env
	rm -rf public/hot
	composer install
	$(SAIL) up -d
php: build
	sleep 10
	$(SAIL) php artisan key:generate
	$(SAIL) php artisan migrate:fresh --seed
npm:
	$(SAIL) npm install
	$(SAIL) npm run build
up: php npm
	@echo "Application is ready!"
dev: php npm
	$(SAIL) npm run dev
stop:
	$(SAIL) stop
