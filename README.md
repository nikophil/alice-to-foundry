Currently, only https://github.com/nelmio/alice/blob/main/doc/complete-reference.md has been made. 

- Alice's fixtures can be found in the `./fixtures` directory.
- The Foundry equivalent version is in `./src/Foundry`
- Some tests are provided to show that the fixtures are equivalent

Few things cannot be done in Foundry:

### Unique constraint on relationships

https://github.com/nelmio/alice/blob/main/doc/complete-reference.md#handling-unique-constraints
```yaml
Nelmio\Entity\User:
    friends{1..2}:
        username (unique): '<username()>'
    user{1..2}:
        friends (unique): '@friends*' # array value
```

As we don't use Faker for this kind of randomization, 
we don't support the `unique` keyword in the `@friends*` syntax. You can use the `unique` keyword only on property where faker is used. 

### Method calls

https://github.com/nelmio/alice/blob/main/doc/complete-reference.md#method-arguments-with-parameters

Such things are not supported in Foundry. You can only pass one values as arguments to methods.
The fact that Foundry supports to call methods [is accidental](https://github.com/zenstruck/foundry/issues/454#issuecomment-1513387542),
and I don't think we want to improve this.

```yaml
Nelmio\Entity\Dummy:
    dummy{1..10}:
        __calls:
            - setLocation:
                arg0: 'bar'
                arg1: '$arg0' # will be resolved info 'bar'
                3: 500  # the numerical key here is just a random number as in YAML you cannot mix keys with array values
                4: '$3' # `3` here refers to the *third* argument, i.e. 500
```
