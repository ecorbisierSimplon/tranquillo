# ---------------------------
# Création du fichier URL
# ---------------------------

if [ ! -f "$file_rel_URL" ]; then
    echo "Création du fichier $file_rel_URL"
    echo "--------------------------------"
    pause s 1 m
    echo $file_rel_URL
    sudo echo "#!/bin/sh" >$file_rel_URL
    sudo echo " " >>$file_rel_URL
    sudo echo " navigateur=\"firefox\"" >>$file_rel_URL
    sudo echo " if dpkg-query -l \"google-chrome-stable\" >/dev/null 2>&1; then" >>$file_rel_URL
    sudo echo "    navigateur=\"google-chrome-stable\"" >>$file_rel_URL
    sudo echo " fi" >>$file_rel_URL
    sudo echo #"echo " >>$file_rel_URL
    sudo echo "\$navigateur \"\$@\"" >>$file_rel_URL

    sudo chmod +x $file_rel_URL
    echo " ** Création effectuée **"
    echo

fi

if ! dpkg-query -l docker-desktop >/dev/null 2>&1; then
    echo "Docker desktop n'est pas installer."
    echo " ** Veux tu l'installer ?"
    echo -e "\e[31m\e[1m[y]\e[0mes / \e[31m\e[1m[n]\e[0mo > "
    read -n 1 -rp " > " val
    line -t ""
    if [[ "${val^^}" == "Y" ]]; then
        echo "Installation de Docker Desktop Ubuntu"
        echo "--------------------------------"
        pause s 1 m

        dl_docker="https://desktop.docker.com/linux/main/amd64/139021/docker-desktop-4.28.0-amd64.deb?utm_source=docker&utm_medium=webreferral&utm_campaign=docs-driven-download-linux-amd64"
        WGET -O $myfolder/install/docker-desktop.deb $dl_docker
        sudo apt-get -y install $myfolder/install/docker-desktop.deb
        echo " ** Création effectuée **"
        echo

    else
        echo
        echo "Installation interrompu !!!"
        echo "Il faut installer Docker Desktop : "
        echo " * Ubuntu : https://docs.docker.com/desktop/install/ubuntu/"
        echo " * Windows et Mac : https://www.docker.com/products/docker-desktop/"
        echo
        exit 1
    fi
fi
