<?php declare(strict_types=1);
namespace Tests\Backoff;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-backoff\Backoff\ExponentialBackoff
 *
 * @author fdipzone
 */
final class ExponentialBackoffTest extends TestCase
{
    /**
     * @covers \Backoff\ExponentialBackoff::__construct
     */
    public function testConstruct()
    {
        $start_retry_interval = 5;
        $max_retry_interval = 300;
        $factor = 2;
        $max_retry_times = 8;

        $exponential_backoff = new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
        $this->assertEquals('Backoff\ExponentialBackoff', get_class($exponential_backoff));
        $this->assertInstanceOf(\Backoff\IBackoff::class, $exponential_backoff);
    }

    /**
     * @covers \Backoff\ExponentialBackoff::__construct
     */
    public function testConstructStartRetryIntervalException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('start retry interval must be greater than 0');

        $start_retry_interval = 0;
        $max_retry_interval = 300;
        $factor = 2;
        $max_retry_times = 8;
        new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
    }

    /**
     * @covers \Backoff\ExponentialBackoff::__construct
     */
    public function testConstructMaxRetryIntervalException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('max retry interval must be greater than start retry interval');

        $start_retry_interval = 100;
        $max_retry_interval = 30;
        $factor = 2;
        $max_retry_times = 8;
        new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
    }

    /**
     * @covers \Backoff\ExponentialBackoff::__construct
     */
    public function testConstructFactorException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('factor must be greater than 0');

        $start_retry_interval = 5;
        $max_retry_interval = 300;
        $factor = 0;
        $max_retry_times = 8;
        new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
    }

    /**
     * @covers \Backoff\ExponentialBackoff::__construct
     */
    public function testConstructMaxRetryTimesException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('max retry times must be greater than 0');

        $start_retry_interval = 5;
        $max_retry_interval = 300;
        $factor = 2;
        $max_retry_times = 0;
        new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
    }

    /**
     * @covers \Backoff\ExponentialBackoff::setRandomFactor
     */
    public function testSetRandomFactor()
    {
        $start_retry_interval = 5;
        $max_retry_interval = 300;
        $factor = 2;
        $max_retry_times = 8;
        $random_factor = 3;

        $exponential_backoff = new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
        $exponential_backoff->setRandomFactor($random_factor);
        $this->assertSame($random_factor, \Tests\Utils\PHPUnitExtension::getVariable($exponential_backoff, 'random_factor'));
    }

    /**
     * @covers \Backoff\ExponentialBackoff::setRandomFactor
     */
    public function testSetRandomFactorException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('random factor must be greater than 0');

        $start_retry_interval = 5;
        $max_retry_interval = 300;
        $factor = 2;
        $max_retry_times = 8;
        $random_factor = 0;

        $exponential_backoff = new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
        $exponential_backoff->setRandomFactor($random_factor);
    }

    /**
     * @covers \Backoff\ExponentialBackoff::randomInterval
     */
    public function testRandomInterval()
    {
        $start_retry_interval = 5;
        $max_retry_interval = 300;
        $factor = 2;
        $max_retry_times = 8;
        $random_factor = 3;

        $exponential_backoff = new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
        $this->assertSame(0, \Tests\Utils\PHPUnitExtension::callMethod($exponential_backoff, 'randomInterval', []));

        $exponential_backoff->setRandomFactor($random_factor);
        $random_interval = \Tests\Utils\PHPUnitExtension::callMethod($exponential_backoff, 'randomInterval', []);
        $this->assertTrue($random_interval>=0 && $random_interval<=$random_factor);
    }

    /**
     * @covers \Backoff\ExponentialBackoff::next
     */
    public function testNext()
    {
        $start_retry_interval = 5;
        $max_retry_interval = 300;
        $factor = 2;
        $max_retry_times = 8;
        $random_factor = 3;

        $exponential_backoff = new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
        $exponential_backoff->setRandomFactor($random_factor);

        $cases = array(
            array(
                'retry_times' => 0,
                'want_retry' => true,
                'want_retry_interval_lower_limit' => 5,
                'want_retry_interval_upper_limit' => 8,
            ),
            array(
                'retry_times' => 1,
                'want_retry' => true,
                'want_retry_interval_lower_limit' => 10,
                'want_retry_interval_upper_limit' => 13,
            ),
            array(
                'retry_times' => 2,
                'want_retry' => true,
                'want_retry_interval_lower_limit' => 20,
                'want_retry_interval_upper_limit' => 23,
            ),
            array(
                'retry_times' => 3,
                'want_retry' => true,
                'want_retry_interval_lower_limit' => 40,
                'want_retry_interval_upper_limit' => 43,
            ),
            array(
                'retry_times' => 4,
                'want_retry' => true,
                'want_retry_interval_lower_limit' => 80,
                'want_retry_interval_upper_limit' => 83,
            ),
            array(
                'retry_times' => 5,
                'want_retry' => true,
                'want_retry_interval_lower_limit' => 160,
                'want_retry_interval_upper_limit' => 163,
            ),
            array(
                'retry_times' => 6,
                'want_retry' => true,
                'want_retry_interval_lower_limit' => 300,
                'want_retry_interval_upper_limit' => 303,
            ),
            array(
                'retry_times' => 7,
                'want_retry' => true,
                'want_retry_interval_lower_limit' => 300,
                'want_retry_interval_upper_limit' => 303,
            ),
            array(
                'retry_times' => 8,
                'want_retry' => false,
                'want_retry_interval_lower_limit' => 0,
                'want_retry_interval_upper_limit' => 0,
            ),
        );

        foreach($cases as $case)
        {
            $request = new \Backoff\Request($case['retry_times']);
            $response = $exponential_backoff->next($request);
            $this->assertSame($case['want_retry'], $response->retry());
            $this->assertTrue($response->retryInterval()>=$case['want_retry_interval_lower_limit'] && $response->retryInterval()<=$case['want_retry_interval_upper_limit']);
        }
    }
}