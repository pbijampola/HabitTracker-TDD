<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Habit;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HabitTest extends TestCase
{
    use RefreshDatabase;
    public function test_habits_view_can_be_rendered(): void
    {
        //Arrange
        $habits = Habit::factory(5)->create();
        //Act
        $response = $this->withoutExceptionHandling()->get('/habits');
        //Assert
        $response->assertStatus(200);
        $response->assertViewHas('habits', $habits);
    }

    public function test_habit_can_be_created()
    {
        //Arrange
        $habits = Habit::factory()->make();

        //Act
        $response = $this->withoutExceptionHandling()->post(
            '/habits',
            $habits->toArray()
        );
        //Assert
        $response->assertRedirect('/habits');
        $this->assertDatabaseHas('habits', $habits->toArray());
    }

    public function test_habit_can_be_updated()
    {
        //Arrange
        $habit = Habit::factory()->create();
        $newHabit = Habit::factory()->make();

        //Act
        $response = $this->withoutExceptionHandling()->put(
            '/habits/' . $habit->id,
            $newHabit->toArray()
        );

        //Assert
        $response->assertRedirect('/habits');
        $this->assertDatabaseHas('habits', $newHabit->toArray());
    }
    /** Few fields */
    public function test_habit_can_not_be_created_without_name()
    {
        //Arrange
        $habits = Habit::factory()->make(['name' => null]);
        //Act
        // $response = $this->withoutExceptionHandling()->post('/habits',$habits->toArray());
        $response = $this->post('/habits', $habits->toArray());

        //Assert
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('habits', $habits->toArray());
    }

    public function test_habit_can_not_be_created_without_time_per_day()
    {
        //Arrange
        $habits = Habit::factory()->make(['time_per_day' => null]);
        //Act
        // $response = $this->withoutExceptionHandling()->post('/habits',$habits->toArray());
        $response = $this->post('/habits', $habits->toArray());

        //Assert
        $response->assertSessionHasErrors(['time_per_day']);
        $this->assertDatabaseMissing('habits', $habits->toArray());
    }

    public function test_update_name_cannot_be_empty(){
        //Arrange
        $habit = Habit::factory()->create();
        $newHabit = Habit::factory()->make(['name' => null]);

        //Act
        $response = $this->put(
            '/habits/' . $habit->id,
            $newHabit->toArray()
        );
        $response->assertSessionHasErrors(['name']);
    }

    public function test_update_time_per_day_cannot_be_empty(){
        //Arrange
        $habit = Habit::factory()->create();
        $newHabit = Habit::factory()->make(['time_per_day' => null]);

        //Act
        $response = $this->put(
            '/habits/' . $habit->id,
            $newHabit->toArray()
        );
        $response->assertSessionHasErrors(['time_per_day']);
    }

    public function test_habit_can_be_deleted()
    {
        //Arrange
        $habit = Habit::factory()->create();

        //Act
        $response = $this->withoutExceptionHandling()->delete('/habits/' . $habit->id);

        //Assert
        $response->assertRedirect('/habits');
        $this->assertDatabaseMissing('habits', ['id',$habit->id]);
    }
}
