<?php

namespace Server\Models;

enum UserRole: int
{
    case RegularUser = 0;
    case Examiner = 1;
}