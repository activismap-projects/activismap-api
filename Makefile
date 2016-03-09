
all: clean test

install:
	bash symfony_install.sh

reload:
	bash symfony_reload.sh

test:
	phpunit

clean:
	rm -rf build
