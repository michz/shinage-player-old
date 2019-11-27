#!/usr/bin/env bash

set -e

echo "Installing requirements"
ansible-galaxy install -r requirements.yml --force

echo "Executing ansible playbook"
ansible-playbook -i inventory/vagrant playbook.yml
