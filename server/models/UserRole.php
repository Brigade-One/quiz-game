<?php

namespace Server\Models\User;

enum UserRole: int
{
    case RegularUser = 0;
    case Examiner = 1;
}