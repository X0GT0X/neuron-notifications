# Executables (local)
DOCKER_COMP = docker compose -f docker-compose.ci.yml

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP_CONT) bin/console

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh composer vendor sf cc

pull:
	@$(DOCKER_COMP) pull

up:
    @$(DOCKER_COMP) up -d --build
