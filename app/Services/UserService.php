<?php

namespace App\Services;

use App\Repositories\Contracts\UserInterface;
use Illuminate\Support\Facades\Log;
use App\Exceptions\UserException;
use App\Http\Resources\UserResource;
use App\Repositories\Core\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\CredentialsException;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use App\Mail\ResidentMail;

class UserService implements UserInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public  function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userRepository->getAll();
    }

    public function paginate(int $id): LengthAwarePaginator
    {
        // TODO: Implement paginate() method.
        return $this->userRepository->paginate($id);
    }

    public function findWhereFirst(string $column, string $value) {
        return $this->userRepository->findWhereFirst($column, $value);
    }

    public function findByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }
    public function applyFilter(array $filters) {
        return $this->userRepository->applyFilter($filters);
    }

    public function findById(int $id)
    {
        return new UserResource($this->userRepository->findById($id));
    }

    public function store(array $data)
    {
        $user = $this->findByEmail($data['email']);

        if ($user) {
            return ['success' => false, 'message' => 'Já existe email cadastrado!'];
        }

        $data['password'] = (isset($data['password']) ? $data['password'] : Str::random(10));
        $this->userRepository->store($data);

        $user = $this->findByEmail($data['email']);
    //   Log::info($user);
        if ($user) {
            $this->sendMail( $data, 'Confirmação de cadastro:  Sistema SGC');
        }

    }

    public function update(array $data, int $id): void
    {

        $user = $this->findById($id);
        $this->userRepository->update($user, $data);
    }

    public function destroy(int $id): void
    {
        $user = $this->findById($id);
        $this->userRepository->destroy($user);
        $user->tokens()->delete();
    }

    /**
     * @throws UserException
     * @throws CredentialsException
     */
    public function login(object $request): string
    {
       $user = $this->userRepository->findWhereFirst('email', $request->email);

       if (isset($user->deleted_at) && $user->deleted_at != null) {
           throw new UserException('Usuário desativado! Favor entrar em contato com a Administração.');
       }
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new CredentialsException($user);
        }
        return $user->createToken($request->email)->plainTextToken;
    }

    public function logout($request): void
    {
        $personalAccessToken = new PersonalAccessToken();
        $token = substr($request->headers->get('authorization'), 7);
        $personalAccessToken->findToken($token)->delete();
    }

    public function updatePassword(string $email, string $password): void
    {
        $this->userRepository->updatePassword(mb_strtolower($email), $password);
    }

    public function restore(int $id): void
    {
        $this->userRepository->restore($id);
    }

    public function getProfileUser(int $user_id)
    {
       return $this->userRepository->getProfileUser($user_id);
    }

    public function loggedInUser($request)
    {
        // TODO: Implement loggedInUser() method.
    }

    private function sendMail($data, $title) {
        $mail = new ResidentMail($data['email'], $title);

        $mail->send($data);
    }


}
