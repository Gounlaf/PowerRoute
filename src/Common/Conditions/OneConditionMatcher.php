<?php
namespace Mcustiel\PowerRoute\Common\Conditions;

use Psr\Http\Message\ServerRequestInterface;

class OneConditionMatcher extends AbstractConditionsMatcher implements ConditionsMatcherInterface
{
    /**
     *
     * {@inheritDoc}
     *
     * @see \Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherInterface::conditionsMatches()
     */
    public function matches(array $conditions, ServerRequestInterface $request)
    {
        foreach ($conditions as $condition) {
            $inputSource = $this->getInputSource($condition);
            $matcher = $this->getMatcher($condition);
            if ($matcher->match($inputSource->getValue($request))) {
                return true;
            }
        }
        return false;
    }
}
