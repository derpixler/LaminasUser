<?php
/**
 * LaminasUser
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @license AGPL-3.0 <https://www.gnu.org/licenses/agpl-3.0.en.html>
 */
namespace LaminasUser\Authentication\Adapter;

use Interop\Container\ContainerInterface;
use LaminasUser\Authentication\Adapter\Exception\OptionsNotFoundException;
use LaminasUser\Options\ModuleOptions;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AdapterChainServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        $chain = new AdapterChain();
        $chain->setEventManager($serviceLocator->get('EventManager'));

        $options = $this->getOptions($serviceLocator);

        //iterate and attach multiple adapters and events if offered
        foreach ($options->getAuthAdapters() as $priority => $adapterName) {
            $adapter = $serviceLocator->get($adapterName);

            if (is_callable(array($adapter, 'authenticate'))) {
                $chain->getEventManager()->attach('authenticate', array($adapter, 'authenticate'), $priority);
            }

            if (is_callable(array($adapter, 'logout'))) {
                $chain->getEventManager()->attach('logout', array($adapter, 'logout'), $priority);
            }
        }

        return $chain;
    }

    /**
     * @var ModuleOptions
     */
    protected $options;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->__invoke($serviceLocator, null);
    }


    /**
     * set options
     *
     * @param ModuleOptions $options
     * @return AdapterChainServiceFactory
     */
    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * get options
     *
     * @param ServiceLocatorInterface $serviceLocator (optional) Service Locator
     * @return ModuleOptions $options
     * @throws OptionsNotFoundException If options tried to retrieve without being set but no SL was provided
     */
    public function getOptions(ServiceLocatorInterface $serviceLocator = null)
    {
        if (!$this->options) {
            if (!$serviceLocator) {
                throw new OptionsNotFoundException(
                    'Options were tried to retrieve but not set ' .
                    'and no service locator was provided'
                );
            }

            $this->setOptions($serviceLocator->get('LaminasUser_module_options'));
        }

        return $this->options;
    }
}
