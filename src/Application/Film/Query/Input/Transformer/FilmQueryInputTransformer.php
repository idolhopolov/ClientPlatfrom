<?php

declare(strict_types=1);

namespace App\Application\Film\Query\Input\Transformer;

use App\Application\Film\Query\Input\DTO\FilmQueryInput;
use Symfony\Component\HttpFoundation\InputBag;

class FilmQueryInputTransformer
{
    public static function makeFromRequest(InputBag $bag): FilmQueryInput
    {
        $filmQueryInput = new FilmQueryInput();

        if(null !== ($withRandom = $bag->get('withRandom')))
        {
            $filmQueryInput->setRandom(filter_var($withRandom, FILTER_VALIDATE_INT));
        }

        if(null !== ($withMultipleWords = $bag->get('withMultipleWords')))
        {
            $filmQueryInput->setMultipleWords(filter_var($withMultipleWords, FILTER_VALIDATE_BOOLEAN));
        }

        if(null !== ($withFirstLetter = $bag->get('withFirstLetter')))
        {
            $filmQueryInput->setFirstLetter(preg_replace('/\s+/', '', $withFirstLetter));
        }

        return $filmQueryInput;
    }
}