#!/bin/sh

git update-index --no-skip-worktree application/config/config.php
git update-index --no-skip-worktree application/config/database.php
git update-index --no-skip-worktree application/config/email.php
git update-index --no-skip-worktree application/config/ion_auth.php

