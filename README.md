# ProudCommerce oxConfig Modulsettings

Edit OXID modul settings: aModules, aModuleEvents, aModuleFiles, aDisabledModules, aModuleVersions, aModuleTemplates, aModuleControllers
Sometimes old module entries are still present in the various OXID oxconfig array values, e.g. old controllers in _aModuleControllers_ and you get errors activating modules (e.g. duplicate controller names etc.) and since the values are arrays andy also encoded in oxconfig, there is no way to edit them directly.

This script removes all DB values for a certain module ID from the internal oxconfig arrays to that everything is in a clean state again and you can (re-)activate problematic modules.

## Usage

1. copy file to `pc_oxconfig-modulsettings.php` into your shop root directory
2. change secret in line 5
3. submit "go" button to see (and change) all module settings (you can submit the form without changing anything and just check the array values)


## Changelog

    2021-10-18  1.1.0   add aModuleControllers array, replace deprecated oxRegistry instances
    2020-10-30  1.0.0   release
    

## License

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

## Copyright

ProudCommerce | www.proudcommerce.com
