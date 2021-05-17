<?php

declare(strict_types=1);

namespace EmagHero\Battle;

use EmagHero\Configuration\GameSettings;
use EmagHero\Output\Output;
use EmagHero\Character\GameCharacterAbstract;
use EmagHero\Character\HeroBuilder;
use EmagHero\Character\BeastBuilder;

/**
 * creates a Hero Vs Beast scenario
 */
class HeroVsBeastBattle implements OneOnOneBattle
{
    private array $battleSettings;
    private int $roundsLeft;
    private GameCharacterAbstract $player_1;
    private GameCharacterAbstract $player_2;
    private Output $output;
    private int $nextAttacker = 1;
    private bool $weHaveAWinner = false;

    public function __construct(GameSettings $config, Output $output)
    {
        try {
            $this->init($config, $output);
            $this->fight();
            $this->report();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            $this->error($e->getMessage());
        }
    }

    /**
     * load configuration, load players
     */
    public function init(GameSettings $config, Output $output): void
    {
        $this->battleSettings = $config->getSettings();
        $this->output = $output;
        $this->roundsLeft = $this->battleSettings['rounds'];
        if ($this->prefightCheck()) {
            $this->readyPlayerOne();
            $this->readyPlayerTwo();
        }
    }

    /**
     * gameplay
     */
    public function fight(): void
    {
        $this->display([
            [
                $this->player_1->getName() . ' (' . $this->player_1->getType() . ')',
                'vs',
                $this->player_2->getName() . ' (' . $this->player_2->getType() . ')'
            ],
            [
                implode("\n", $this->player_1->export()),
                '',
                implode("\n", $this->player_2->export()),
            ],
        ]);

        while ($this->roundsLeft > 0 && !$this->weHaveAWinner) {
            $this->roundsLeft--;
            $this->round();
        }
    }

    /**
     * who won
     */
    public function report(): void
    {
        $player1Health = $this->player_1->getAttribute('health');
        $player2Health = $this->player_2->getAttribute('health');
        if ($player1Health > $player2Health) {
            $this->display([
                [
                    'The winner is ' . $this->player_1->getName()
                ]
            ]);
        } else if ($player1Health < $player2Health) {
            $this->display([
                [
                    'The winner is ' . $this->player_2->getName()
                ]
            ]);
        } else {
            $this->display([
                [
                    'The battle is tied',
                ]
            ]);
        }
    }

    /**
     * which player attackes next
     */
    private function findNextAttacker(int $round): int
    {
        if ($round === 1) {
            $player1Speed = $this->player_1->getAttribute('speed');
            $player2Speed = $this->player_2->getAttribute('speed');
            if ($player1Speed === $player2Speed) {
                $player1Luck = $this->player_1->getAttribute('luck');
                $player2Luck = $this->player_2->getAttribute('luck');
                if ($player1Luck >= $player2Luck) {
                    $this->nextAttacker = 1;
                } else {
                    $this->nextAttacker = 2;
                }
            } else if ($player1Speed > $player2Speed) {
                $this->nextAttacker = 1;
            } else {
                $this->nextAttacker = 2;
            }
        } else {
            $this->nextAttacker = ($this->nextAttacker === 2) ? 1 : 2;
        }

        return $this->nextAttacker;
    }

    /**
     * turn
     */
    private function round(): void
    {
        $round = $this->battleSettings['rounds'] - $this->roundsLeft;
        $this->display([['ROUND ' . $round]]);

        if ($this->findNextAttacker($round) === 1) {
            // player 1 attacks
            $this->attackerKicksDefender($this->player_1, $this->player_2, $round);
        } else {
            // player 2 attacks
            $this->attackerKicksDefender($this->player_2, $this->player_1, $round);
        }
    }

    /**
     * kick
     */
    private function attackerKicksDefender(
        GameCharacterAbstract $attacker,
        GameCharacterAbstract $defender
    ) {
        // initial values
        $damage = 0;
        $attackerStrength = $attacker->getAttribute('strength');
        $defenderHealth = $defender->getAttribute('health');
        $defenderDefence = $defender->getAttribute('defence');
        $defenderLuck = $defender->getAttribute('luck');
        $defenderIsLucky = (rand(0, 99) < $defenderLuck) ? true : false;

        $outputTable = [];
        $outputTable[] = ['Attacker', 'Defender'];
        $outputTable[] = [$attacker->getName(), $defender->getName()];

        // assuming only heroes have skills ...
        $attackerSkillModifier = 1;
        if ($attacker->getType() == 'hero') {
            foreach ($attacker->getAttackingSkillsByChance() as $skillName => $modifier) {
                $outputTable[] = ['Using ' . $skillName];
                $attackerSkillModifier *= $modifier;
            }
        }
        $defenderSkillModifier = 1;
        if ($defender->getType() == 'hero') {
            foreach ($defender->getDefendingSkillsByChance() as $skillName => $modifier) {
                $outputTable[] = ['', 'Using ' . $skillName];
                $attackerSkillModifier *= $modifier;
            }
        }

        if (!$defenderIsLucky) { // no luck for defender
            $damage = ($attackerStrength - $defenderDefence) * $attackerSkillModifier *
                $defenderSkillModifier;
            // $damage = ($damage > 0) ? $damage : 0;
            $defenderHealth -= $damage;
            $outputTable[] = ['Damage: ' . $damage, 'Health: ' . $defenderHealth];
            $this->display($outputTable);
            if ($defenderHealth <= 0) {
                $this->weHaveAWinner = true;
            }
            // update defender's health
            $defender->updateAttribute('health', $defenderHealth);
        } else {
            $outputTable[] = ['Damage: ' . $damage, 'Health: ' . $defenderHealth];
            $this->display($outputTable);
            $this->display([['The defender got lucky']]);
        }
    }

    /**
     * validates battle configuration
     */
    public function prefightCheck(): bool
    {
        // may also check here if one is hero and one is beast,
        // if all required properties are set correctly etc.
        if (
            isset($this->battleSettings['player_1']) &&
            isset($this->battleSettings['player_2'])
        ) {
            return true;
        }
        return false;
    }

    /**
     * load hero
     */
    public function readyPlayerOne(): void
    {
        $this->player_1 = $this->createHero(new HeroBuilder());
    }

    /**
     * load beast
     */
    public function readyPlayerTwo(): void
    {
        $this->player_2 = $this->createBeast(new BeastBuilder());
    }

    /**
     * create hero from configuration
     */
    public function createHero(HeroBuilder $builder): GameCharacterAbstract
    {
        $builder->createCharacter();
        $builder->addName($this->battleSettings['player_1']['characterName']);
        $builder->addAttributes($this->battleSettings['player_1']['attributes']);
        $builder->addSkills($this->battleSettings['player_1']['skills']);
        return $builder->getCharacter();
    }

    /**
     * create beast from configuration
     */
    public function createBeast(BeastBuilder $builder): GameCharacterAbstract
    {
        $builder->createCharacter();
        $builder->addName($this->battleSettings['player_2']['characterName']);
        $builder->addAttributes($this->battleSettings['player_2']['attributes']);
        return $builder->getCharacter();
    }

    /**
     * sends data to output
     */
    private function display(array $data): void
    {
        $this->output->display($data);
    }
}
