<?php

namespace App\Events;

use App\Models\Student;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('students'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'student.updated';
    }

    /**
     * Dito natin sinisiguro ang format ng data na ipapadala sa browser
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->student->id,
            'first_name' => $this->student->first_name,
            'last_name' => $this->student->last_name,
            'email' => $this->student->email,
            'student_number' => $this->student->student_number,
            'year_level' => $this->student->year_level_label ?? $this->student->year_level, 
            'course' => $this->student->course,
        ];
    }
}