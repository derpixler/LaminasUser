<?php
/**
 * LaminasUser
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @license AGPL-3.0 <https://www.gnu.org/licenses/agpl-3.0.en.html>
 */

namespace LaminasUser\Factory\View\Helper;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use LaminasUser\View;

class LaminasUserLoginWidget implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $viewHelper = new View\Helper\LaminasUserLoginWidget;
        $viewHelper->setViewTemplate($container->get('LaminasUser_module_options')->getUserLoginWidgetViewTemplate());
        $viewHelper->setLoginForm($container->get('LaminasUser_login_form'));

        return $viewHelper;
    }
}
