docker info > /dev/null 2>&1
# Ensure that Docker is running...
if [ $? -ne 0 ]; then
    echo "Docker is not running."

    exit 1
fi
docker run --rm -it \
	-v $(pwd):/opt \
	-w /opt laravelsail/php81-composer:latest \
	/bin/bash -c "composer self-update && composer diagnose && composer install && cp .env.example .env && php ./artisan sail:install --with=mysql"

CYAN='\033[0;36m'
LIGHT_CYAN='\033[1;36m'
WHITE='\033[1;37m'
NC='\033[0m'

echo ""

if sudo -n true 2>/dev/null; then
    sudo chown -R $USER: .
    echo -e "${WHITE}Get started with:${NC} ./vendor/bin/sail up"
else
    echo -e "${WHITE}Please provide your password so we can make some final adjustments to your application's permissions.${NC}"
    echo ""
    sudo chown -R $USER: .
    echo ""
    echo -e "${WHITE}Thank you! We hope you build something incredible. Dive in with:${NC} ./vendor/bin/sail up"
fi
