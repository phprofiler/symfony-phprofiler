<?php

namespace PHProfiler\Symfony\EventListener;

use DateTime;
use DateTimeInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class PHProfilerListener
{
    protected Client $client;
    private bool $enabled;
    private string $dsn;
    private Security $security;
    private RequestStack $requestStack;

    public function __construct(Client $client, bool $enabled, string $dsn, Security $security, RequestStack $requestStack)
    {
        $this->client = $client;
        $this->enabled = $enabled;
        $this->dsn = $dsn;
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$this->enabled || !$event->isMasterRequest()) {
            return;
        }

        if (!function_exists('phprofiler_enable')) {
            throw new \RuntimeException('PHProfiler extension is not loaded');
        }

        phprofiler_enable();
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$this->enabled || !$event->isMasterRequest()) {
            return;
        }

        if (!function_exists('phprofiler_disable')) {
            throw new \RuntimeException('PHProfiler extension is not loaded');
        }

        $request = $this->requestStack->getCurrentRequest();

        $data = array_merge(phprofiler_disable(), [
            'action' => sprintf('%s %s', $request->getMethod(), $request->getPathInfo()),
            'server_name' => $request->getHost(),
            'user' => $this->security->getUser() ? $this->security->getUser()->getId() : null,
            'ip' => $request->getClientIp(),
            'created_at' => (new DateTime())->format(DateTimeInterface::ATOM),
        ]);

        $this->sendData($data);
    }

    protected function sendData(array $data): void
    {
        $this->client->postAsync($this->dsn, [
            'json' => $data,
            'timeout' => 0.1,
        ]);
    }
}