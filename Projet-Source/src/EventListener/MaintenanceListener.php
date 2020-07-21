<?php


namespace App\EventListener;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceListener implements ParameterBagInterface
{
    private $params;
    private $env;
    public function __contruct(ParameterBagInterface $params,$env)
    {
        $this->params = $params;
        $this->env = $env;
    }

    public function methode()
    {
        $maintenance = $this->has('maintenance') ? $this->get('maintenance') : false;
        if($this->env== "dev")
        {
            return $this->render('dashboard/maintenance.html.twig');
        }

       // $debug=$this->params->get("kernel.environment") === "dev";

        /*dump(get('kernel.environment') );die();
        if($debug)
        {
            return true;
        }*/

        // If maintenance is active and in prod environment
                if ($maintenance ) {
                    // We load our maintenance template
                    $engine = $this->container->get('templating');
                    $template = $engine->render('::maintenance.html.twig');


                }


    }
    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function add(array $parameters)
    {
        // TODO: Implement add() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function get($name)
    {
        // TODO: Implement get() method.
    }

    public function remove($name)
    {
        // TODO: Implement remove() method.
    }

    public function set($name, $value)
    {
        // TODO: Implement set() method.
    }

    public function has($name)
    {
        // TODO: Implement has() method.
    }

    public function resolve()
    {
        // TODO: Implement resolve() method.
    }

    public function resolveValue($value)
    {
        // TODO: Implement resolveValue() method.
    }

    public function escapeValue($value)
    {
        // TODO: Implement escapeValue() method.
    }

    public function unescapeValue($value)
    {
        // TODO: Implement unescapeValue() method.
    }



}